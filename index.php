<?php
  if(isset($_POST['button'])){
    $imgUrl = $_POST['imgurl'];
    $ch = curl_init($imgUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $downloadImg = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment;filename="thumbnail.jpg"');
    echo $downloadImg;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stahování miniatur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="video.png" type="image/x-icon">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <header>Stažení miniatury</header>
        <div class="url-input">
            <span class="title"> Vložte url videa</span>
            <div class="field">
                <input type="text" placeholder="https://www.youtube.com/watch?v=pEoGojv0KjE" required>
                <input class="hidden-input" type="hidden" name="imgurl">
                <span class="bottom-line"></span>
            </div>
        </div>
        <div class="preview-area">
            <img class="thumbnail" src="" alt="">
            <i class="icon fas fa-cloud-download-alt"></i>
            <span>pro zobrazení náhledu vložte adresu URL videa</span>
        </div>
        <button class="download-btn" type="submit" name="button">stáhnout miniaturu</button>
    </form>
    <script>
        const urlField = document.querySelector(".field input"),
        previewArea = document.querySelector(".preview-area"),
        imgTag = previewArea.querySelector(".thumbnail"),
        hiddenInput = document.querySelector(".hidden-input"),
        button = document.querySelector(".download-btn");
    
        urlField.onkeyup = ()=>{
          let imgUrl = urlField.value;
          previewArea.classList.add("active");
          button.style.pointerEvents = "auto";
          if(imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1){
            let vidId = imgUrl.split('v=')[1].substring(0, 11);
            let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
            imgTag.src = ytImgUrl;
          }else if(imgUrl.indexOf("https://youtu.be/") != -1){
            let vidId = imgUrl.split('be/')[1].substring(0, 11);
            let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
            imgTag.src = ytImgUrl;
          }else if(imgUrl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)){
            imgTag.src = imgUrl;
          }else{
            imgTag.src = "";
            button.style.pointerEvents = "none";
            previewArea.classList.remove("active");
          }
          hiddenInput.value = imgTag.src;
        }
      </script>
</body>
</html>