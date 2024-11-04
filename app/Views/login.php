<h2>Login</h2>
<form action="<?= site_url('authenticate'); ?>" method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
