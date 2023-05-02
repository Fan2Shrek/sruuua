<!DOCTYPE html>
<html>

<head>
    <title>There is a problem</title>
    <style>
        <?= $this->render('styles/styles.css'); ?>
    </style>
</head>

<body>
    <div id='header'>
        <h2><?= $message ?> </h2>
    </div>
    <div id='trace-container'>
        <h3>Trace :</h3>
        <table>
            <thead>
                <tr>
                    <th>Class</th>
                    <th>Function</th>
                    <th>File</th>
                    <th>Line</th>
                </tr>
            </thead>
            <tbody>
                <?= $this->render('views/trace.html.php', ['trace' => $trace]); ?>
            </tbody>
        </table>
    </div>
</body>

</html>