<a href="/">Back</a><br>

<h1>Musicians page</h1>
<h3><a href="/musicians/add">Add musician</a></h3>

<?php foreach($musicians as $musician): ?>
    <article>
        <b>Musician name: <?php echo $musician->name; ?></b><br>
        <a href="/musicians/<?php echo $musician->id; ?>">Click to see more details!</a>
    </article>
    <hr>
<?php endforeach;
