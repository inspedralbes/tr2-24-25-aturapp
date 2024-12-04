<template>
    <div class="d-flex j-center align-center py-40">
        <select name="planta" id="planta">
            <option value="planta0">Planta baja</option>
            <option value="planta1">Planta 1</option>
            <option value="planta2">Planta 2</option>
            <option value="planta3">Planta 3</option>
        </select>
    </div>
    <div id="circle" class="d-flex j-center align-center">
        <p id="sos">SOS</p>
    </div>
</template>

<script setup>

</script>

<style scoped>
    #circle{
        height: 150px;
        width: 150px;
        border-radius: 150px;
        background: red;
        border: 5px solid #d10000;
        position: absolute;
        top: 0;
        bottom: 70px;
        left: 0;
        right: 0;
        margin: auto;
    }
    
    #sos{
        font-size: 60px;
        color: white;
    }

    select{
        border: 0;
        background: none;
        outline: none;
    }

    select:focus{
        outline: none;
    }

    #planta{
        border: 1px solid black;
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 16px;
    }
</style>