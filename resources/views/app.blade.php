<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @routes
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
<script>
    function getbooks(){
        //document.getElementById('output').innerHTML="";
        var outP= document.getElementById('output');
        outP.innerHTML="";
        fetch("https://openlibrary.org/search.json?q="+document.getElementById('input').value)
        .then(a=>a.json())
        .then(response=>{for(var i=0; i<10; i++){
                var title= "";
                //console.log(response.docs[i].title);
                title+=response.docs[i].title;
                //console.log(response.docs[i].editions.docs[0].subtitle);
                if (!(response.docs[i].editions.docs[0].subtitle==null)){
                    title+=': '+response.docs[i].editions.docs[0].subtitle;
                }
                outP.innerHTML+='<h2>'+title+'</h2>';
                if(!(response.docs[i].editions.docs[0].cover_i==null)){
                    outP.innerHTML+='<img src="https://covers.openlibrary.org/b/id/'+response.docs[i].editions.docs[0].cover_i+'-M.jpg" id="'+response.docs[i].editions.docs[0].cover_i+'">';
                }else{
                    outP.innerHTML+='<img class="w-28" src="https://www.drupal.org/files/project-images/broken-image.jpg">';
                }
                if(!(response.docs[i].author_name==null)){
                    outP.innerHTML+='Autor: '+response.docs[i].author_name;
                }
                outP.innerHTML+='<hr class="border border-sky-500">';
            }
                
        })
    }
</script>