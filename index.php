<?php
if (!empty($_REQUEST['Sender'])):
    $sender = $_REQUEST['Sender'];
    $layout = file_get_contents('./layout.html', FILE_USE_INCLUDE_PATH);

    foreach ($sender as $key => $value) {
        $key         = strtoupper($key);
        $start_if    = strpos($layout, '[[IF-' . $key . ']]');
        $end_if      = strpos($layout, '[[ENDIF-' . $key . ']]');
        $length      = strlen('[[ENDIF-' . $key . ']]');

        if (!empty($value)) {
            // Add the value at its proper location.
            $layout = str_replace('[[IF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[ENDIF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[' . $key . ']]', $value, $layout);
        } elseif (is_numeric($start_if)) {
            // Remove the placeholder and brackets if there is an if-statement but no value.
            $layout = str_replace(substr($layout, $start_if, $end_if - $start_if + $length), '', $layout);
        } else {
            // Remove the placeholder if there is no value.
            $layout = str_replace('[[' . $key . ']]', '', $layout);
        }
    }

    // Clean up any leftover placeholders. This is useful for booleans,
    // which are not submitted if left unchecked.
    $layout = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout);

    if (!empty($_REQUEST['download'])) {
        header('Content-Description: File Transfer');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename=assinatura.html');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }

    echo $layout;
else: ?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Lucas Machado">

        <title>Falck & Co Signatur Generator</title>

        <!-- Bootstrap core CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style type="text/css">


            html,
            body {
                height: 100%;
               
            }

          
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
               
                margin: 0 auto -60px;
               
                padding: 0 0 60px;
            }

        
            #footer {
                height: 60px;
                background-color: #f5f5f5;
            }


            /* Custom page CSS
            -------------------------------------------------- */
           

            #wrap > .container {
                padding: 60px 15px 0;
            }
            .container .credit {
                margin: 20px 0;
            }

            #footer > .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            code {
                font-size: 80%;
            }
        </style>

    </head>

    <body>

       
        <div id="wrap">

            


            <!--  page content -->
            <div class="container">
                <div class="page-header">
                    <h1>REUTERDAHLS PÅ ÖSTERLEN Signatur Generator</h1>
                </div>
                <form role="form" method="post" target="preview" id="form">
                    <div class="form-group">
                        <label for="Name">Namn</label>
                        <input type="text" class="form-control" id="Name" name="Sender[name]" placeholder="Namn">
                    </div>
                    <div class="form-group">
                        <label for="Name">Titel</label>
                        <input type="text" class="form-control" id="Title" name="Sender[title]" placeholder="Titel">
                    </div>
                    <div class="form-group">
                        <label for="Email">Epost</label>
                        <input type="email" class="form-control" id="Email" name="Sender[email]" placeholder="Epost">
                    </div>

                    <div class="form-group">
                        <label for="Mobile">Mobil</label>
                        <input type="phone" class="form-control" id="Mobile" name="Sender[mobile]" placeholder="+XX (XX) XXXXX-XXXX">
                    </div>


                    <button id="preview" type="submit" class="btn btn-default">Generera</button>
                    <button id="download" class="btn btn-default">Ladda ner</button>
                    <input type="hidden" name="download" id="will-download" value="">
                </form>
            </div>

            <div class="container">
                <iframe src="about:blank" name="preview" width="100%" height="400"></iframe>
            </div>

            <div class="container">
<h1>Instruktioner för de flesta mailprogram</h1>
<h3>1. Fyll i dina uppgifter</h3>
<p>När du är klar så klickar du på knappen generera</p>
<h3>2. Kopiera den genererade signaturen.</h3>
<p>Markera och kopiera. Var noga med att få med allt när du markerar innehållet i rutan.</p>
<h3>3. Klistra in</h3>
<p>Öppna signaturhanteraren i din epostklient och klistra in signaturen du nyss kopierat och spara</p>
<h3>3. Klart!</h3>

				<h1>Instruktioner outlook 2010</h1>


				<h3>1. Skapa och spara signatur</h3>
				<p>Fyll i dina uppgifter i formuläret ovan. Klicka generera och kontrollera att allt stämmer. Klicka download för att spara filen <code>signatur.txt</code> på din dator.</p>


				<h3>2. Lägg till temporär signatur i outlook</h3>
				<p>Gå till <code>File > Options > Mail</code> i outlook och tryck på "Signatures"-knappen. Klicka "New" för att skapa en ny (temporär) signatur. Ge den ett namn du kommer ihåg.</p>

				<h3>3. Öppna mappen med outlooks signaturer</h3>
				<p>Mappen signatures ligger på följande ställen beroende på operativsystem:</p>

				<h4>Windows 7 och Windows Vista</h4>
				<p><code>C:\Users\username\AppData\Roaming\Microsoft\Signatures</code></p>

				<h4>Windows XP</h4>
				<p><code>C:\Documents and Settings\username\Application Data\Microsoft\Signatures</code></p>

				<p>Obs: "Show hidden files and folders" måste vara aktiverat för att filerna ska synas.</p>

				<h3>4. Öppna signaturfilen från steg 2</h3>
				<p>Leta rätt på den temporära signaturfilen du skapade i steg 2, den har samma filnamn som det namn du gav den och filändelsen <code>.html</code>. Det kan finnas flera filer med samma namn men olika filändelser, så se till så att du väljer den som heter <code>.html</code>.</p>
				<p>Högerklicka på filen och välj "Öppna med" och välj "Anteckningar" (Notepad på engelska).</p>

				<h3>5. Klistra in skapad signatur</h3>
				<p>Öppna filen <code>signatur.txt</code> från steg 1, kopera innehållet och klistra in det i signaturfilen du nyss öppnade.</p>

				<h3>6. Välj den nya signaturen i outlook</h3>
				<p>Gå till <code>File > Options > Mail > Signatures</code>, som i steg 1. Välj den signatur du tidigare skapade. Nu borde du se din nya signatur.</p>
				<p>På högra sidan kan du välja vilken signatur du vill använda till nya meddelanden och när du svarar på mail. Klicka ner rullistan och välj din nya signatur.</p>




			</div>


        </div>




        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        $( document ).ready(function() {
            $("#download").bind( "click", function() {
                $('#will-download').val('true');
                $('#form').removeAttr('target').submit();
            });

            $("#preview").bind( "click", function() {
                $('#will-download').val('');
                $('#form').attr('target','preview');
            });

        });
        </script>
    </body>
</html>
<?php endif;
