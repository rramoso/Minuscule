<table width="600" cellpadding="0" cellspacing="0" align="center">
    <tr>
        <td width="600">
            <h2>Forgot Password</h2>
            <p>A forgot password attempt has been logged for your account - you can reset your password by following the link: <a
                    href="<?= site_url('login/forgot/' . $token); ?>">here</a>.</p>
            <p>Or by copying the url into your browser: <?= site_url('login/forgot/' . $token); ?></p>
        </td>
    </tr>
</table>