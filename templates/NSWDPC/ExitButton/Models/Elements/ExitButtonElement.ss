<% if $ExitButton %>
<div class="content-element__exitbutton<% if $StyleVariant %> {$StyleVariant}<% end_if %>">
    <% if $Title && $ShowTitle %>
        <h2>{$Title}</h2>
    <% end_if %>
    {$ExitButton}
</div>
<% end_if %>
