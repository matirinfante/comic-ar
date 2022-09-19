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
    function getbooks(option){
        var outP= document.getElementById('output');
        outP.innerHTML="";
        var att= outP.getAttribute('val');
        var btnNext=document.getElementById('next');
        var btnPrev=document.getElementById('prev');
        var i=0;
        if (option=="1"){
            outP.setAttribute('val',0);
            btnNext.classList.add('hidden');
            btnPrev.classList.add("hidden");
        }
        if (option=="2"){
            outP.setAttribute('val',(parseInt(att)-1));
            att= outP.getAttribute('val');
            i=10*(parseInt(att));
        }
        if (option=="3"){
            outP.setAttribute('val',(parseInt(att)+1));
            att= outP.getAttribute('val');
            i=10*(parseInt(att));
        }
        var cantVol=i+10;
        
        fetch("https://openlibrary.org/search.json?q="+document.getElementById('input').value)
        .then(a=>a.json())
        .then(response=>{
            //Compruebo la cantidad de volumenes para establecer el estado del boton Siguiente
            if (cantVol<response.docs.length){
                btnNext.classList.remove("hidden");
            }else{
                cantVol=response.docs.length;   //Para no buscar datos que no existen en el for
                btnNext.classList.add("hidden");
            }   
            //Compruebo la cantidad de volumenes para establecer el estado del boton Anterior
            if (cantVol>10){
                btnPrev.classList.remove("hidden");
            }else{
                btnPrev.classList.add("hidden");
            }  
            outP.innerHTML+='<h1>'+response.docs.length+' coincidencias</h1>';
            //Genero el codigo con la info de los volumenes
            for(i; i<cantVol; i++){
                var title= "";
                title+=response.docs[i].title;
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