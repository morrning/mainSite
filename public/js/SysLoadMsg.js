var SysIsModalOn = false;

$(document).ready(function(){
    $('.JdateInput').mask('0000/00/00');
    $('.MoneyInput').mask('000,000,000,000,000',{reverse: true})
});

function SysChangeValueMoney(value,id)
{
    $('.MoneyInput' + id).val(value.replace(/,/g,''));
}
function SysCheckMax(value,id,maxValue)
{
    if(! $.isNumeric(value))
    {
        alert();
    }
}
function SysLoadMsg(helpID) {
    $.ajax({
        url: Routing.generate('SystemLoadMessage', { 'id': helpID }),
        success: function(data) {
            SysCreateModal(data)
        }
    });
}

function SysCheckDateInput(date,id)
{
    if(date.length != 0)
    {
        $.ajax({
            url: Routing.generate('SystemJdateValidation', { 'jdate': '**' + date + '**' }),
            success: function(data) {
                if(data != 'ok')
                {
                    SysCreateModal(data)
                    $('.jdateInputTextbox' + id).addClass('is-invalid').removeClass('is-valid');
                    $('.jdateInputTextbox' + id).val('');
                    $('.jdateIconValidation' + id).html('close');
                }
                else
                {
                    $('.jdateInputTextbox' + id).addClass('is-valid').removeClass('is-invalid');
                    $('.jdateIconValidation' + id).html('done');
                }

            }
        });
    }

}

function SysCreateModal(data)
{
    var modal = '<!-- Modal -->\n' +
        '<div class="modal fade" id="SystemModalCenter" tabindex="-1" role="dialog" aria-labelledby="SystemModalCenter" aria-hidden="true">\n' +
        '    <div class="modal-dialog modal-dialog-centered" role="document">\n' +
        '    <div class="modal-content">\n' +
        '    <div class="modal-header bg-info text-light">\n' +
        '    <h5 class="modal-title" id="exampleModalLongTitle">راهنما</h5>\n' +
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
        '    <span aria-hidden="true">&times;</span>\n' +
        '</button>\n' +
        '</div>\n' +
        '<div class="modal-body">\n' +
        data +
        '</div>\n' +
        '<div class="modal-footer">\n' +
        '    <button type="button" class="btn btn-secondary" data-dismiss="modal">' +
        '<i class="material-icons">close</i> ' +
        'بستن' +
        '</button>\n' +
        '</div>\n' +
        '</div>\n' +
        '</div>\n' +
        '</div>';
    if(SysIsModalOn == false)
    {
        $('.SystemModal').empty();
        $('.SystemModal').append(modal);
        $('#SystemModalCenter').on('show.bs.modal', function (e) {
            SysIsModalOn = true;
        })

        $('#SystemModalCenter').on('hidden.bs.modal', function (e) {
            SysIsModalOn = false;
        })
        $('#SystemModalCenter').modal();
    }

}