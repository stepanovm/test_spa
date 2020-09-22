<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Single Page Application</title>
        <script async type="text/javascript" src="/resources/js/jquery-2.1.3.min.js"></script>
        <script async type="text/javascript" src="/resources/js/table.js"></script>
        <script async type="text/javascript" src="/resources/js/main.js"></script>
        <link href="/resources/css/main.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>Table SPA test</h1>

        <div class="filter-container">
            <label for="f_field">Поле:</label>
            <select id="f_field">
                <option value="nm">name</option>
                <option value="qnt">quanyity</option>
                <option value="dst">distance</option>
            </select>
            <label for="f_operator">Условие:</label>
            <select id="f_operator">"equals", "match", "greater", "less"
                <option value="equals">равно</option>
                <option value="match">содержит</option>
                <option value="greater">больше</option>
                <option value="less">меньше</option>
            </select>
            <label for="f_value">Значение:</label>
            <input type="text" id="f_value"/>
            <input type="button" value="применить"/>
        </div>

        <div class="table-container">
            <table id="spa_table">
                <tr class="spa_tbl_header">
                    <th data-sort="nm">name<span class="sort"></span></th>
                    <th data-sort="qnt">quanyity<span class="sort"></span></th>
                    <th data-sort="dst">distance<span class="sort"></span></th>
                    <th class="th-date">date</th>
                </tr>
            </table>
        </div>

        <div id="pagination"></div>

    </body>
</html>