<h1>Lead List</h1>

<a class="btn" href="/leads/create">Create Lead</a>

<br><br>

<form method="get" action="/leads" class="search-form">
    <input
        type="text"
        name="keyword"
        value="<?= e($keyword ?? '') ?>"
        placeholder="Search by code, name, email, phone, source, status"
    >

    <button type="submit">Search</button>
    <a href="/leads">Reset</a>
</form>

<br>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th><a href="/leads?keyword=<?= e($keyword ?? '') ?>&sort=id&direction=DESC">ID</a></th>
        <th><a href="/leads?keyword=<?= e($keyword ?? '') ?>&sort=lead_code&direction=ASC">Lead Code</a></th>
        <th><a href="/leads?keyword=<?= e($keyword ?? '') ?>&sort=full_name&direction=ASC">Name</a></th>
        <th>Email</th>
        <th>Phone</th>
        <th>Source</th>
        <th><a href="/leads?keyword=<?= e($keyword ?? '') ?>&sort=status&direction=ASC">Status</a></th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    </thead>

    <tbody>
    <?php if (empty($leads)): ?>
        <tr>
            <td colspan="9">No leads found.</td>
        </tr>
    <?php endif; ?>

    <?php foreach ($leads as $lead): ?>
        <tr>
            <td><?= e((string) $lead['id']) ?></td>
            <td><?= e($lead['lead_code']) ?></td>
            <td><?= e($lead['full_name']) ?></td>
            <td><?= e($lead['email']) ?></td>
            <td><?= e($lead['phone']) ?></td>
            <td><?= e($lead['source']) ?></td>
            <td><?= e($lead['status']) ?></td>
            <td><?= e($lead['created_at']) ?></td>
            <td>
                <a href="/leads/edit?id=<?= e((string) $lead['id']) ?>">Edit</a>

                <form
                    method="post"
                    action="/leads/delete"
                    style="display:inline;"
                    onsubmit="return confirm('Delete this lead?');"
                >
                    <input type="hidden" name="id" value="<?= e((string) $lead['id']) ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<br>

<?php if (($totalPages ?? 1) > 1): ?>
    <div>
        Pages:

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a
                href="/leads?keyword=<?= e($keyword ?? '') ?>&page=<?= $i ?>"
                style="<?= ($i === ($page ?? 1)) ? 'font-weight:bold; color:red;' : '' ?>"
            >
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>