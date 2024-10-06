<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odontograma</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: sans-serif;
        }

        .container {
            margin-top: 20px;
        }

        .odontograma {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-template-rows: repeat(4, 1fr);
            gap: 10px;
        }

        .diente {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .diente.selected {
            background-color: lightblue;
        }

        .diente .numero {
            font-size: 12px;
            font-weight: bold;
        }
        
        .marcado {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: none;
        }

        .marcado.fractura {
            background-color: red;
        }

        .marcado.obturacion {
            background-color: blue;
        }

        .marcado.extraida {
            background-color: yellow;
        }

        .marcado.extraer {
            background-color: rgb(28, 194, 22);
        }

        .marcado.puente {
            background-color: rgb(105, 104, 105);
        }

        .boton {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Odontograma</h2>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
                <button class="btn btn-danger boton" data-tipo="fractura">Fractura</button>
                <button class="btn btn-primary boton" data-tipo="obturacion">Obturación</button>
                <button class="btn btn-warning boton" data-tipo="extraida">Extraída</button>
                <button class="btn btn-success boton" data-tipo="extraer">Extraer</button>
                <button class="btn btn-secondary boton" data-tipo="puente">Puente</button>
                <button class="btn btn-dark boton" id="borrar">Borrar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="odontograma">
                    <div class="diente" data-numero="18">
                        <span class="numero">18</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <!-- Repite la estructura de los dientes aquí -->
                    <div class="diente" data-numero="17">
                        <span class="numero">17</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="16">
                        <span class="numero">16</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="15">
                        <span class="numero">15</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="14">
                        <span class="numero">14</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="13">
                        <span class="numero">13</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="12">
                        <span class="numero">12</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="11">
                        <span class="numero">11</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="55">
                        <span class="numero">55</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="54">
                        <span class="numero">54</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="53">
                        <span class="numero">53</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="52">
                        <span class="numero">52</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="51">
                        <span class="numero">51</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="61">
                        <span class="numero">61</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="62">
                        <span class="numero">62</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="63">
                        <span class="numero">63</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="64">
                        <span class="numero">64</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="65">
                        <span class="numero">65</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="85">
                        <span class="numero">85</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="84">
                        <span class="numero">84</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="83">
                        <span class="numero">83</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="82">
                        <span class="numero">82</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="81">
                        <span class="numero">81</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="71">
                        <span class="numero">71</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="72">
                        <span class="numero">72</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="73">
                        <span class="numero">73</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="74">
                        <span class="numero">74</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="75">
                        <span class="numero">75</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="48">
                        <span class="numero">48</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="47">
                        <span class="numero">47</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="46">
                        <span class="numero">46</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="45">
                        <span class="numero">45</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="44">
                        <span class="numero">44</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="43">
                        <span class="numero">43</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="42">
                        <span class="numero">42</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="41">
                        <span class="numero">41</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="31">
                        <span class="numero">31</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="32">
                        <span class="numero">32</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="33">
                        <span class="numero">33</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="34">
                        <span class="numero">34</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="35">
                        <span class="numero">35</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="36">
                        <span class="numero">36</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="37">
                        <span class="numero">37</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="38">
                        <span class="numero">38</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="21">
                        <span class="numero">21</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="22">
                        <span class="numero">22</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="23">
                        <span class="numero">23</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="24">
                        <span class="numero">24</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="25">
                        <span class="numero">25</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="26">
                        <span class="numero">26</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="27">
                        <span class="numero">27</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>
                    <div class="diente" data-numero="28">
                        <span class="numero">28</span>
                        <div class="marcado fractura"></div>
                        <div class="marcado obturacion"></div>
                        <div class="marcado extraida"></div>
                        <div class="marcado extraer"></div>
                        <div class="marcado puente"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
     <script>
        let selectedTipo = null;

        document.querySelectorAll('.boton').forEach(boton => {
            boton.addEventListener('click', function() {
                selectedTipo = this.getAttribute('data-tipo');
            });
        });

        document.querySelectorAll('.diente').forEach(diente => {
            diente.addEventListener('click', function() {
                if (selectedTipo === 'borrar') {
                    this.querySelectorAll('.marcado').forEach(marca => {
                        marca.style.display = 'none';
                    });
                } else if (selectedTipo) {
                    const marca = this.querySelector(`.marcado.${selectedTipo}`);
                    if (marca) {
                        marca.style.display = 'block';
                    }
                }
            });
        });

        document.getElementById('borrar').addEventListener('click', function() {
            selectedTipo = 'borrar';
        });
    </script>
</body>
</html>
