(function(){
    var id_url_input = "#inp_post_submit_url_post";
    var id_title_input = "#inp_post_submit_title_post";
    var id_text_input = "#inp_post_submit_text_post";
    var id_url_image_input = "#inp_post_submit_url_image_post";
    var selector_image_container = ".component.inp_post_submit_url_image_post.hidden";

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
        if(data.images)
        {
            var container = document.querySelector(selector_image_container);
            var block = document.querySelector("#submit_images_list");
            if(!block)
            {
                block = document.createElement('div');
                block.setAttribute("id", "submit_images_list");
                block.classList.add('images_list');
                container.appendChild(block);
            }
            else
            {
                block.innerHTML = "";
            }
            var src;
            var img;
            for(var i in data.images)
            {
                if(!data.images.hasOwnProperty(i))
                    continue;
                src = data.images[i];
                img = document.createElement('img');
                img.src = src;
                img.addEventListener('click', selectImageHandler, false);
                block.appendChild(img);
                if(i=="0")
                {
                    selectImageHandler({currentTarget:img});
                }
            }
        }
    }

    function selectImageHandler(e)
    {
        var img = e.currentTarget;
        document.querySelectorAll('img.selected').forEach(function(pItem){
            pItem.classList.remove('selected');
        });
        img.classList.add('selected');
        document.querySelector(id_url_image_input).value = img.src;
    }

    window.addEventListener("DOMContentLoaded", init, false);
})();

NodeList.prototype.forEach = Array.prototype.forEach;

String.prototype.html_entity_decode = function()
{
    var d = document.createElement("div");
    d.innerHTML = this.toString();
    return d.firstChild.nodeValue;
};