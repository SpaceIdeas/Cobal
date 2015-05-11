<tr>
    <td>{$nonAdmin->getUsername()}</td>
    <td>{$nonAdmin->getEmail()}</td>
    <td><a href="makeUserAdmin.php?email={$nonAdmin->getEmail()}&makeAdmin=1" class="btn btn-default">Gjør admin<a></td>
</tr>