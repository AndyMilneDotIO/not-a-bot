<?PHP
    session_start();

    if(isset($_REQUEST['reset']) && $_REQUEST['reset'] == "true")
        session_unset();

    if(isset($_REQUEST['not_a_bot']) && $_REQUEST['not_a_bot'] == true)
    {

    }

    if(!isset($_SESSION['attempts']))
        $_SESSION['attempts'] = 0;

    if(isset($_REQUEST['timeout']) && $_REQUEST['timeout'] == "true")
        $_SESSION['attempts']++;

    if(isset($_REQUEST['id']) && isset($_SESSION['valid_code']))
        $_REQUEST['id'] == $_SESSION['valid_code'] ? $_SESSION['not_a_bot'] = true : $_SESSION['attempts']++;

    $codes = Array(uniqid(),uniqid(),uniqid(),uniqid(),uniqid(),uniqid(),uniqid(),uniqid(),uniqid());
    $collectionA = Array(
        "61657d0b7a0a0",
        "61657d0b7a0a1",
        "61657d0b7a0a2",
        "61657d0b7a08e",
        "61657d0b7a09a",
        "61657d0b7a09b",
        "61657d0b7a09c",
        "61657d0b7a09d",
        "61657d0b7a09e",
        "61657d0b7a09f",
        "61657d0b7a09f",
        "61657d0b7a095",
        "61657d0b7a096",
        "61657d0b7a097",
        "61657d0b7a098",
        "61657d0b7a099"
    );
    $collectionB = Array(
        "61657d0b7a0a3",
        "61657d0b7a0a4",
        "61657d0b7a0a5",
        "61657d0b7a0a6",
        "61657d0b7a0a7",
        "61657d0b7a0a8",
        "61657d0b7a0a9",
        "61657d0b7a0aa",
        "61657d0b7a0ab",
        "61657d0b7a0ac",
        "61657d0b7a0ad",
        "61657d0b7a0ae",
        "61657d0b7a0af",
        "61657d0b7a0b0",
        "61657d0b7a0b1",
        "61657d0b7a0b2"
    );
    $validCode = $codes[rand(0,count($codes) - 1)];
    $_SESSION['valid_code'] = $validCode;
    
    $cells = "";
    for($i = 0; $i < 9; $i++)
    {
        $cells .= '<div class="cell" id="'. $codes[$i] .'"><img src="media/';
        if($codes[$i] != $validCode)
            $cells .= $collectionA[rand(0,count($collectionA) - 1)];
        else
            $cells .= $collectionB[rand(0,count($collectionB) - 1)];
        $cells .= '.png"></div>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        I'm Not a Bot!
        <?php 
            if(isset($_SESSION['attempts']) && $_SESSION['attempts'] >= 3)
                echo " - Honest!";
        ?>
    </title>
    <style>
        *
        {
            box-sizing: border-box;
        }
        body
        {
            background-color: #000;
            color: #fff;
            font-family: sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .app
        {
            width: 192px;
        }
        .heading
        {
            font-size: 150%;
            text-align: center;
            width: 100%;
            padding: 0px;
            margin: 0;
        }
        p
        {
            text-align: center;
            width: 100%;
            padding: 0px;
            margin: 0;
        }
        .grid
        {
            display: grid;
            grid-template-columns: 3fr 3fr 3fr;
        }
        .cell
        {
            display: grid;
            align-items: center;
            justify-items: center;
            width: 64px;
            height: 64px;
            border: 1px solid #fff;
            font-size: 3rem;
            cursor: pointer;
            transition: 250ms ease;
            z-index: 1;
        }
        .cell:hover
        {
            z-index: 2;
            font-size: 4rem;
            box-shadow: 0 0 0.8rem #fff;
        }
        img
        {
            width: 100%;
        }
        .button
        {
            padding: 8px 16px;
            border-radius: 16px;
            background-color: #0094ff;
            text-align: center;
            cursor: pointer;
            transition: 250ms ease;
        }
        .button:hover
        {
            box-shadow: 0 0 0.8rem #fff;     
        }
        .timer
        {
            border: 1px solid #fff;
            width: 100%;
            position: relative;
        }
        .countdown
        {
            position: absolute;
            top: 0;
            left: 0;
            background-color: #0f0;
            width: 100%;
            height: 100%;
            transform-origin: left;
            transform: scaleX(0);
            transition: 3s linear;
            z-index: -1;
        }
    </style>
    <script>
        window.onload=function()
        {
            const countdown = document.getElementById("countdown");
            if(countdown)
            {
                countdown.style.transform = "scaleX(1)";
                countdown.style.backgroundColor = "#f00";
                setTimeout(function(){window.location.replace("./?timeout=true");},3000);
            }

            const cells = document.querySelectorAll(".cell");
            if(cells)
                cells.forEach((cell) => {cell.addEventListener("click", function(){window.location.replace("./?id=" + cell.getAttribute("id"));});});

            const reset = document.getElementById("reset");
            if(reset)
                reset.addEventListener("click", function(){window.location.replace("./?reset=true");});
        }
    </script>
</head>
<body>
    <?php
        if(isset($_SESSION['attempts']) && $_SESSION['attempts'] >= 3)
        {
            ?>
                <div class="app">
                    <div class="heading">You have failed</div>
                    <img src="maybe.png">
                    <div class="button" id="reset">Reset</div>
                </div>
            <?php
        }
        else
        {
            if(!isset($_SESSION['not_a_bot']))
            {
                ?>
                    <div class="app">
                        <div class="heading">Not a Bot?</div>
                        <p>Click the odd one out</p>
                        <div class="grid">
                            <?php
                                if(isset($cells))
                                {
                                    echo $cells;
                                }
                            ?>
                        </div>
                        <div class="timer">
                            <div class="countdown" id="countdown"></div>
                            <p>Attempt <?php echo $_SESSION['attempts'] + 1; ?> of 3</p>
                        </div>
                    </div>
                <?php
            }
            else
            {
                ?>
                    <div class="app">
                        <div class="heading">You are human!</div>
                        <div class="button" id="reset">Reset</div>
                    </div>
                <?php
            }
        }
    ?>

</body>
</html>