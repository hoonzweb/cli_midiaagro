<form action="<?= url("/buscar"); ?>" <?= (!empty($class) ? 'class="'.$class.'"' : ''); ?>>
    <label class="w-100">
        <input class="form-control" type="text" name="s" placeholder="<?= $placeholder ?? 'O que você procura?'; ?>">
    </label>
    <button type="submit" class="btn icon-search icon-notext main_header_menu_btn"></button>
</form>