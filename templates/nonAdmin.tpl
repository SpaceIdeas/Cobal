<tr>
    <td>{$nonAdmin->getUsername()}</td>
    <td>{$nonAdmin->getEmail()}</td>
    <td><a href="makeUserAdmin.php?email={$nonAdmin->getEmail()}&amp;makeAdmin=1" class="btn btn-primary">Gjør admin</a></td>
</tr>