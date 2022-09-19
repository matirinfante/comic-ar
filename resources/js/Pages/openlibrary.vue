<template>
    <div class="container">
        <h1>TOMOS</h1>
        <div>
            <label for="input">Nombre del tomo:</label>
            <input id="input" type="text">
        </div>
        <button onclick="getbooks(1)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
        <div id="output" val="0"></div>
        <button id="prev" onclick="getbooks(2)" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded hidden">Anterior</button>
        <button id="next" onclick="getbooks(3)" class="bg-red-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded hidden">Siguiente</button>
    </div>
    
</template>
