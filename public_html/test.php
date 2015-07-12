<?php
error_reporting(E_ALL);
if ($_FILES) {
    $source_image = $_FILES['uploaded_image']['tmp_name'];
    $destination = $_SERVER['DOCUMENT_ROOT'].'/filename.jpg';
    $tn_w = 400;
    $tn_h = 400;
    $quality = 100;
    $wmsource = $_SERVER['DOCUMENT_ROOT'].'/img/picture-bg.png';
    $success = image_handler($source_image, $destination, $tn_w, $tn_h, $quality, $wmsource);
    if ($success) {
        echo "Your image was saved successfully!";
    } else {
        echo "Your image was not saved.";
    }
}

function image_handler($source_image, $destination, $tn_w = 100, $tn_h = 100, $quality = 80, $wmsource = false)
{

    #find out what type of image this is
    $info = getimagesize($source_image);
    $imgtype = image_type_to_mime_type($info[2]);

    #assuming the mime type is correct
    switch ($imgtype) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source_image);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source_image);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source_image);
            break;
        default:
            die('Invalid image type.');
    }

    #Figure out the dimensions of the image and the dimensions of the desired thumbnail
    $src_w = imagesx($source);
    $src_h = imagesy($source);
    $src_ratio = $src_w / $src_h;
    #Do some math to figure out which way we'll need to crop the image
    #to get it proportional to the new size, then crop or adjust as needed
    if ($tn_w / $tn_h > $src_ratio) {
        $new_h = $tn_w / $src_ratio;
        $new_w = $tn_w;
    } else {
        $new_w = $tn_h * $src_ratio;
        $new_h = $tn_h;
    }
    $x_mid = $new_w / 2;
    $y_mid = $new_h / 2;
    $newpic = imagecreatetruecolor(round($new_w), round($new_h));
    imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
    $final = imagecreatetruecolor($tn_w, $tn_h);
    imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);

    #if we need to add a watermark
    if ($wmsource) {
        #find out what type of image the watermark is
        $info = getimagesize($wmsource);
        $imgtype = image_type_to_mime_type($info[2]);

        #assuming the mime type is correct
        switch ($imgtype) {
            case 'image/jpeg':
                $watermark = imagecreatefromjpeg($wmsource);
                break;
            case 'image/gif':
                $watermark = imagecreatefromgif($wmsource);
                break;
            case 'image/png':
                $watermark = imagecreatefrompng($wmsource);
                break;
            default:
                die('Invalid watermark type.');
        }

        #if we're adding a watermark, figure out the size of the watermark
        #and then place the watermark image on the bottom right of the image
        $wm_w = imagesx($watermark);
        $wm_h = imagesy($watermark);
//        imagecopy($final, $watermark, $tn_w - $wm_w, $tn_h - $wm_h, 0, 0, $tn_w, $tn_h);
        $img_paste_x = 0;
        while($img_paste_x < $tn_w){
            $img_paste_y = 0;
            while($img_paste_y < $tn_h){
                imagecopy($final, $watermark, $img_paste_x, $img_paste_y, 0, 0, $wm_w, $wm_h);
                $img_paste_y += $wm_h;
            }
            $img_paste_x += $wm_w;
        }
    }
    if (Imagejpeg($final, $destination, $quality)) {
        return true;
    }
    return false;
}

echo $_SERVER['DOCUMENT_ROOT'].'/img/picture-bg.png';
?>

<form method="post" enctype="multipart/form-data">
    Source Image: <input type="file" name="uploaded_image" />
    <input type="submit" value="Handle This Image" />
</form>

