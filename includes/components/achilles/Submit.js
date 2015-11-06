(function(){
    var id_url_input = "#inp_post_submit_url_post";
    var id_title_input = "#inp_post_submit_title_post";
    var id_text_input = "#inp_post_submit_text_post";
    var id_url_image_input = "#inp_post_submit_url_image_post";

    var url_scrap = "post/scrap";

    var request;

    var data;

    function init()
    {
        document.querySelector(id_url_input).addEventListener("change", urlChangedHandler, false);
    }

    function urlChangedHandler(e)
    {
        var url = e.currentTarget.value;

        if(!url.match(/^http:\/\//))
        {
            return false;
        }
        document.querySelector(id_title_input).setAttribute("disabled","disabled");
        document.querySelector(id_text_input).setAttribute("disabled","disabled");

        if(request)
        {
            request.cancel();
        }

        request = new Request(url_scrap, {'url':url}, 'post');
        request.onComplete(function(e)
        {
            if(!e.responseJSON||!e.responseJSON.data)
            {
                console.log("should check url");
                return;
            }
            data = e.responseJSON.data;
            updateFields();
        });
    }

    function updateFields()
    {
        if(data.title)
        {
            document.querySelector(id_title_input).value = data.title.html_entity_decode();
            document.querySelector(id_title_input).removeAttribute("disabled");
        }
        if(data.text)
        {
            document.querySelector(id_text_input).value = data.text.html_entity_decode();
            document.querySelector(id_text_input).removeAttribute("disabled");
        }
    }

    window.addEventListener("DOMContentLoaded", init, false);
})();


String.prototype.html_entity_decode = function()
{
    var d = document.createElement("div");
    d.innerHTML = this.toString();
    return d.firstChild.nodeValue;
};