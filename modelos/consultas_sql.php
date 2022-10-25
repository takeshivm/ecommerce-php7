<?php

// CONSULTAR NOMBRES DE LAS TALLAS O COLORES  DE UN PRODUCTO ESPECIFICO

'SELECT t.nombre as color, c.nombre FROM productos p JOIN detalle_producto d on p.id = d.id_producto
	JOIN color c on c.id = d.id_color
    JOIN talla t on t.id = d.id_talla
    WHERE p.id = 1 and d.stock > 0
    GROUP by t.id';



