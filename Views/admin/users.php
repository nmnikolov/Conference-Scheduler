<?php  /** @var \Framework\Models\ViewModels\AdminUsersViewModel $model */ ?>

<h3>Users</h3>

<table class="table table-striped">
    <thead>
    <tr>
        <th>
            N
        </th>
        <th>
            Username
        </th>
        <th>
            FullName
        </th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 0; ?>
    <?php foreach ($model->getUsers() as $user): ?>
        <?php $i += 1; ?>
        <tr>
            <td>
                <?= $i ?>
            </td>
            <td>
                <?= $user["username"] ?>
            </td>
            <td>
                <?= $user["fullname"] ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>