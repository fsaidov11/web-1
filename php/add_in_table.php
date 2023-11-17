<tr class="table-header">
    <th scope="col">X</th>
    <th scope="col">Y</th>
    <th scope="col">R</th>
    <th scope="col">Current time</th>
    <th scope="col">Execution time</th>
    <th scope="col">Result</th>
</tr>

<?php foreach ($_SESSION["response"] as $value) { ?>
    <tr class="table-row">
        <td><?php echo $value[0] ?></td>
        <td><?php echo $value[1] ?></td>
        <td><?php echo $value[2] ?></td>
        <td><?php echo $value[3] ?></td>
        <td><?php echo $value[4] ?> ms</td>
        <?php echo $value[5] ? "<td style='color: green'>IN</td>" : "<td style='color: red'>OUT</td>"; ?>
    </tr>
<?php } ?>