<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/php/fecha.php");
$idioma = idioma();
include($_SERVER["DOCUMENT_ROOT"] . "/php/idiomas/$idioma.php");
session_start();
?>
<div hidden title="<?= $lang[$idioma]["profile"] ?>" id="profileForm">
    <div class="profileContent">
        <div class="profileRow">
            <div class="smallCell stackHorizontally bold alignRight">
                <?= $lang[$idioma]['Nombre'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input disabled type="text" class="fullInput alignCenter entradaTexto"
                       value="<?= $_SESSION["nom"] ?> <?= $_SESSION["apel"] ?>">
            </div>
        </div>
        <div class="profileRow">
            <div class="smallCell stackHorizontally bold alignRight">
                <?= $lang[$idioma]['emailContacto'] ?>
            </div>
            <div class="largeCell stackHorizontally">
                <input disabled type="text" class="fullInput alignCenter entradaTexto" value="<?= $_SESSION["user"] ?>">
            </div>
        </div>
        <div class="profileRow">
            <div class="smallCell stackHorizontally bold alignRight">
                <?= $lang[$idioma]['signature'] ?>
            </div>
            <div class="largeCell stackHorizontally alignCenter">
                <div id="imageHolder">
                    <?php
                    $codigo = $_SESSION["codigo"];
                    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/imagenes/firmas/$codigo.jpg")) {
                        ?>
                        <img id="imagePreview" src="/imagenes/firmas/<?= $_SESSION["codigo"] ?>.jpg">
                        <?
                    }
                    else {
                        ?>
                        NO IMAGE
                        <?
                    }
                    ?>
                    <br>
                </div>
                <input id="signatureUpload" class="alignCenter" type="file">
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".callProfile").click(function () {
            openProfile();
        });

        function openProfile() {
            if ($("#profileForm").hasClass("ui-dialog-content") &&
                $("#profileForm").dialog("isOpen")) {
                $("#profileForm").dialog("open");
            } else {
                $("#profileForm").dialog({
                    width: 775,
                    height: 500,
                    modal: true,
                });
            }
        }

        function closeProfile() {
            $("#cargosProyectoForm").dialog('close');
        }
    });
    $("#signatureUpload").change(function () {
        var formData = new FormData();
        formData.append('file', this.files[0]);
        $.ajax({
            url: "/php/signatureUploader.php",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                console.log(response);
                $("#imageHolder").html(
                    '<img id="imagePreview" src="' + response + '?'+ Math.floor(Math.random() * 100) + 1  +'">'
                );
            }
        });
    })
</script>
<style>
    .profileContent {
        width: 100%;
        height: 100%;
    }
    .profileRow {
        width: 100%;
        height: 30px;
    }
    .smallCell {
        width: 25%;
    }
    .mediumCell {
        width: 50%;
    }
    .largeCell {
        width: 75%;
    }
    .fullCell {
        width: 100%;
    }
    .bold {
        font-weight: bold;
    }
    .stackHorizontally {
        float: left;
    }
    .alignRight {
        text-align: right;
    }
    .alignCenter {
        text-align: center;
    }
    .fullInput {
        width: 100%;
    }
    .entradaTexto {
        border-radius: 10px 10px 10px 10px;
    }
    #imagePreview {
        max-width: 500px;
        max-height: 500px;
        width: auto;
        height: auto;
    }
</style>