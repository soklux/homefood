<td><?= $title ?></td>
<td class="permission">
    <input value="all" type="checkbox" name="Authitem_name_all">
</td>

<?php foreach (Authitem::model()->getAuthItemData($permission) as $id => $item): ?>
    <td class="permission">
        <input value="<?= $item["name"]; ?>" type="checkbox" name="Authitem_name_all">
    </td>
<?php endforeach; ?>

<style>
    .role-table td.permission{
        min-width: 70px;
        text-align: center;
    }
</style>
