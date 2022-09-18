<template>
    <div class="container">
        <h1>TOMOS</h1>
        <div>
            <label for="input">Nombre del tomo:</label>
            <input id="input" type="text">
        </div>
        <button onclick="getbooks()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
        <div id="output"></div>
    </div>
    
</template>
