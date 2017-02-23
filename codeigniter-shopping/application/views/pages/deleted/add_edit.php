<p>This is the add_edit page</p>

<form action="#" method="POST">
    <label>Add/Edit</label>
    <input name="title" type='text' placeholder="Add a job here" value="<?= $todo->title; ?>"/>
    <input type="submit" value="Submit" />
    <i style="color: red;"><?php echo validation_errors(); ?></i>
</form>
<i style="color: blue;"><?php echo anchor('/todos', '<-go back'); ?></i>