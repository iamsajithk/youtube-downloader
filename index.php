<?php
$id = NULL;
$full_url = NULL;
if (isset($_POST['id']) and $_POST['id'] != "") {
    $full_url = $_POST['id'];
    $values = explode("v=", $_POST['id']);
    $id = $values[1];
    if ($id != "") {
        $data = file_get_contents("https://www.youtube.com/get_video_info?video_id={$id}");
        parse_str($data);
        $arr = explode(",", $url_encoded_fmt_stream_map);
    }
}
?>
<html>
    <head>
        <title>Youtube Download</title>
        <style>

            body {
                color: #333;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                font-size: 14px;
                line-height: 1.42857;
            }
            .btn {
                -moz-user-select: none;
                background-image: none;
                border: 1px solid transparent;
                border-radius: 4px;
                cursor: pointer;
                display: inline-block;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857;
                margin-bottom: 5px;
                padding: 6px 12px;
                text-align: center;
                vertical-align: middle;
                white-space: nowrap;
                text-decoration: none;
            }
            .btn:focus, .btn:active:focus, .btn.active:focus {
                outline: thin dotted;
                outline-offset: -2px;
            }
            .btn:hover, .btn:focus {
                color: #333;
                text-decoration: none;
            }
            .btn:active, .btn.active {
                background-image: none;
                box-shadow: 0 3px 5px rgba(0, 0, 0, 0.125) inset;
                outline: 0 none;
            }
            .btn-primary {
                background-color: #428bca;
                border-color: #357ebd;
                height: 40px;
                color: #fff;
            }
            .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary {
                background-color: #3071a9;
                border-color: #285e8e;
                color: #fff;
            }
            .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary {
                background-image: none;
            }
            .btn-default {
                background-color: #fff;
                border-color: #ccc;
                color: #333;
            }
            .btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open > .dropdown-toggle.btn-default {
                background-color: #e6e6e6;
                border-color: #adadad;
                color: #333;
            }
            .btn-default:active, .btn-default.active, .open > .dropdown-toggle.btn-default {
                background-image: none;
            }
        </style>
    </head>
    <body>
        <div style='width: 100%;margin-top: 100px;text-align: center'>
            <form method='POST' enctype="multipart/form-data" action='index.php' onsubmit="prefixtrim()">
                <input id='video_url' style='width: 50%;height: 40px;color: #0000ff;font-size: 20px;' autocomplete="off" type='text' name='id' value='<?= $full_url ?>' placeholder="Paste the youtube video URL here" onclick="clearContent()" />
                <input class='btn btn-primary' type='submit' value='Download' name='submit'>
            </form>
        </div>
        <?php if (isset($arr[0])) { ?>
            <div style='width: 90%;margin-left: 5%;background-color: #ccffff;height:auto;min-height: 100px;'>
                <div style='text-align: center;margin-top: 10px;'><h3 style='padding-top: 10px;'><?= $title ?></h3></div>
                <div style='padding: 10px;display: inline-block;text-align: center'>
                    <?php
                    foreach ($arr as $item) {
                        parse_str($item);
                        $temp = explode(";", $type);
                        $extensions = explode("/", $temp[0]);
                        $extension = $extensions[1];
                        switch ($extension) {
                            case '3gpp':
                                $icon = "3gp.PNG";
                                break;
                            case 'mp4':
                                $icon = "mp4.PNG";
                                break;
                            case 'webm':
                                $icon = "webm.PNG";
                                break;
                            case 'x-flv':
                                $icon = "flv.PNG";
                                break;
                        }
                        ?>
                        <a href='<?= $url ?>?title= <?= $title ?>' style='text-decoration: none;display: inline-block;'>
                            <div style='background-color: #fff;min-height: 100px;width:200px;border-radius: 4px;float: left;margin: 10px;color: #537625;text-align: center;padding: 10px;'>
                                <h4><?= $title . "_" . $quality . "." . $extension ?></h4>
                                <img src='<?= $icon ?>' alt='Icon' />
                            </div>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
        <script>
            function prefixtrim() {
                var url = document.getElementById("video_url").value;
                var protomatch = /^(https?|ftp):\/\//; // NB: not '.*'
                var b = url.replace(protomatch, '');
                document.getElementById("video_url").value = b;
            }
            function clearContent() {
                document.getElementById("video_url").value = "";
            }
        </script>
    </body>
</html>