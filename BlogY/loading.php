<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <style>
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            z-index: 999;
        }

        .body {
            background-color: white;
        }
    </style>
</head>
<body class="body">
    <div id="loading">
        <img src="resim/loading.gif" alt="Yükleniyor..." />
    </div>
    <script>
        window.addEventListener('load', fg_load)
        function fg_load() {
            document.getElementById('loading').style.display = 'none'
        }
    </script>
</body>

</html>