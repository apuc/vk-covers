<?php
/**
 * Created by PhpStorm.
 * User: apuc0
 * Date: 19.01.2018
 * Time: 23:26
 */
?>
<div>
    <a href="#" id="setC">Установить координаты</a>
</div>
<div style="margin: 50px auto; width: 1000px; height: 500px; border: 1px solid black; position: relative">
    <div id="d1" style="position: absolute; top: 10px; left: 10px; background-color: #d03d28; width: 100px; height: 100px;"></div>
    <div id="d2" style="position: absolute; top: 10px; left: 890px; background-color: #00a7d0; width: 100px; height: 100px;"></div>
    <div id="d3" style="position: absolute; top: 10px; left: 450px; background-color: #ced023; width: 100px; height: 100px;"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        $cg('#d1').draggable({
            parentBoxCross:false,
        });
        $cg('#d1').resizable();
        $cg('#d2').draggable();
        $cg('#d3').draggable();
        var set = document.getElementById('setC');
        set.onclick = function () {
            $cg('#d2').draggable().setCoordinates(300, 300);
        }
    });
</script>
