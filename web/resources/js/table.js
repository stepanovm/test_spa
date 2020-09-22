function Table() {

    let obj = this;

    this.params = {
        'page': 1
    };


    this.load = function () {
        obj.htmlManager.clearTable();
        $.ajax({
            url: '/api/testspa/get' + getParamsString(),
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // console.log(jsonData);
                if (response['error']) {
                    console.log(response['error']);
                    alert(response['error']);
                } else {
                    obj.htmlManager.writeTable(response['spa_data']);
                    obj.htmlManager.writePagination(response['spa_size']);
                }
            },
            error: function (jqXHR, status, msg) {
                alert('Произошла ошибка. Пожалуйста, попробуйте повторить позже');
                console.log(jqXHR);
                console.log(msg + ' ' + status);
            }
        });
    };

    function getParamsString() {
        let paramsStr = '';
        if (obj.params) {
            let pairs = [];
            paramsStr += '?';
            for (let key in obj.params) {
                pairs.push(key + '=' + obj.params[key]);
            }
            paramsStr += pairs.join('&');
        }
        return paramsStr;
    };

    this.setSort = function (field, type) {
        this.params.sortby = field;
        this.params.sorttype = type;
        this.params.page = 1;
    }

    this.setFilter = function(field, operator, value) {
        this.params.f_by = field;
        this.params.f_opr = operator;
        this.params.f_val = value;
        this.params.page = 1;
    }


    this.htmlManager = {

        tableContainer: $('#spa_table'),
        paginationContainer: $('#pagination'),

        clearTable: function() {
            $('#spa_table tr:not(.spa_tbl_header)').remove();
        },

        writeTable: function (spa_data) {
            for (var i in spa_data) {
                this.tableContainer.append(this.createRow(
                    spa_data[i]['name'],
                    spa_data[i]['quantity'],
                    spa_data[i]['distance'],
                    spa_data[i]['date']
                ));
            }
        },

        writePagination: function (spa_size) {
            this.paginationContainer.html('');
            for (let i = 1; i <= spa_size; i++) {
                $btn = $('<div>', {text: i});
                if(obj.params['page'] === i){
                    $btn.addClass('active');
                } else {
                    $btn.click(function(){
                        obj.params.page = i;
                        obj.load();
                    });
                }
                this.paginationContainer.append($btn);
            }
        },

        createRow: function (name, quantity, distance, date) {
            let $row = $('<tr>');
            $row.append($('<td>', {text: name}));
            $row.append($('<td>', {text: quantity}));
            $row.append($('<td>', {text: distance}));
            $row.append($('<td>', {text: date}));
            return $row;
        }
    };

};