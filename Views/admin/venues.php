<?php  /** @var \Framework\Models\ViewModels\AdminVenuesViewModel $model */ ?>

<h3>Venues</h3>

<a href="<?= \Framework\Helpers\Helpers::url() . "admin/venues/create" ?>" class="btn btn-success">Add venue</a>

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
            Description
        </th>
        <th>
            Address
        </th>
        <th>
            Status
        </th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0; ?>
    <?php foreach ($model->getVenues() as $venue): ?>
        <?php $i += 1; ?>
        <tr class="category-active-@item.IsActive.ToString()">
            <td>
                <?= $i ?>
            </td>
            <td>
                <?= htmlspecialchars($venue["name"]); ?>
            </td>
            <td>
                <?= htmlspecialchars($venue["description"]); ?>
            </td>
            <td>
                <?= htmlspecialchars($venue["address"]); ?>
            </td>
            <td>
                <?= $venue["isActive"] ? "Active" : "Inactive" ?>
            </td>
            <td>
                <?php if ($venue["isActive"]): ?>
                    <a href="<?= \Framework\Helpers\Helpers::url() . "admin/venues/" . htmlspecialchars($venue["id"]) . "/edit" ?>">Edit</a> |
                    <a href="<?= \Framework\Helpers\Helpers::url() . "admin/venues/" . htmlspecialchars($venue["id"]) . "/deactivate" ?>">Deactivate</a>
                <?php else: ?>
                    <a href="<?= \Framework\Helpers\Helpers::url() . "admin/venues/" . htmlspecialchars($venue["id"]) . "/activate" ?>">Activate</a>
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>