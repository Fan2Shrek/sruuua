<?php

foreach ($trace as $t) { ?>
    <tr>
        <td><?= $t['class'] ?? ''; ?></td>
        <td><?= $t['function'] ?? '';
            echo '()'; ?></td>
        <td><?= $t['file'] ?? ''; ?></td>
        <td><?= $t['line'] ?? ''; ?></td>
    </tr>

<?php } ?>