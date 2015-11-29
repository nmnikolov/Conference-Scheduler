<?php  /** @var \Framework\Models\ViewModels\AdminHallsViewModel $model */ ?>

<h3>Halls</h3>
<a href="<?= \Framework\Helpers\Helpers::url() . "admin/halls/create" ?>" class="btn btn-success">Add hall</a>

<table class="table table-striped">
    <thead>
    <tr>
        <th>
            N
        </th>
        <th>
            Name
        </th>
        <th>
            Capacity
        </th>
        <th>
            Venue
        </th>
        <th>
            Status
        </th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0; ?>
    <?php foreach ($model->getHalls() as $hall): ?>
        <?php $i += 1; ?>
        <tr class="category-active-@item.IsActive.ToString()">
            <td>
                <?= $i ?>
            </td>
            <td>
                <?= htmlspecialchars($hall["name"]); ?>
            </td>
            <td>
                <?= htmlspecialchars($hall["capacity"]); ?>
            </td>
            <td>
                <?= htmlspecialchars($hall["venue"]); ?>
            </td>
            <td>
                <?= $hall["isActive"] ? "Active" : "Inactive" ?>
            </td>
            <td>
                <?php if ($hall["isActive"]): ?>
                    <a href="<?= \Framework\Helpers\Helpers::url() . "admin/halls/" . htmlspecialchars($hall["id"]) . "/edit" ?>">Edit</a> |
                    <a href="<?= \Framework\Helpers\Helpers::url() . "admin/halls/" . htmlspecialchars($hall["id"]) . "/deactivate" ?>">Deactivate</a>
                <?php else: ?>
                    <a href="<?= \Framework\Helpers\Helpers::url() . "admin/halls/" . htmlspecialchars($hall["id"]) . "/activate" ?>">Activate</a>
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>