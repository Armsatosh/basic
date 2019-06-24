/*
 * @author ToolBox Software  - www.toolbox.am
 */
 jQuery.fn.toolboxCreditCalculator = function( options ){
    
    var instance = this;
    
    var values = {
        tbccAmount: null,
        tbccPercent: null,
        tbccTerms: null,
        tbccType: null
    };
    
    var tbccAmount = instance.find('input[name=tbcc-amount]');
    var tbccPercent = instance.find('input[name=tbcc-percent]');
    var tbccTerms = instance.find('input[name=tbcc-terms]');
    var tbccType = instance.find('select[name=tbcc-type]');
    var buttonCalculate = instance.find('.tbcc-count');
    
    var tableResults = $('.tbcc-results');
    var tableResultsTbody = tableResults.find('tbody');
    
    init(instance);
    
    function init(instance){
        
        buttonCalculate.on('click', function(e){
            
            e.preventDefault();
            
            values.tbccAmount = parseInt(tbccAmount.val());
            values.tbccPercent = parseInt(tbccPercent.val());
            values.tbccTerms = parseInt(tbccTerms.val());
            values.tbccType = parseInt(tbccType.val());
            
            if(values.tbccType == 0){
                
                tableResultsTbody.html('');
                
                var previousBalance = values.tbccAmount;
                var paymentTotal = (values.tbccAmount * (values.tbccPercent/100)/12)/(1-(1/(Math.pow((1+(values.tbccPercent/100)/12), values.tbccTerms))));
                
                var totalPaymentBalance = 0;
                var totalPaymentPercent = 0;
                
                for(var i = 0; i <= values.tbccTerms; i++){
                    
                    if(i == 0){
                        
                        var appendRow = "<tr><td>"+i+"</td><td>"+previousBalance+"</td><td></td><td></td><td></td></tr>";
                        tableResultsTbody.append(appendRow);
                        
                    } else {
                        
                        var paymentPercent = ((previousBalance * (values.tbccPercent/100))/12);
                        var paymentBalance = (paymentTotal - paymentPercent);

                        previousBalance = (previousBalance - paymentBalance);
                        if(previousBalance < 0){ previousBalance = 0; }
                        
                        totalPaymentBalance = totalPaymentBalance + paymentBalance;
                        totalPaymentPercent = totalPaymentPercent + paymentPercent;
                        
                        var appendRow = "<tr><td>"+i+"</td><td>"+previousBalance.toFixed(2)+"</td><td>"+paymentPercent.toFixed(2)+"</td><td>"+paymentBalance.toFixed(2)+"</td><td>"+paymentTotal.toFixed(2)+"</td></tr>";
                        tableResultsTbody.append(appendRow);
                        
                    }
                    
                }
                
                var appendRow = "<tr><td></td><td></td><td><b>"+totalPaymentPercent.toFixed(2)+"</b></td><td><b>"+totalPaymentBalance.toFixed(2)+"</b></td><td><b>"+(totalPaymentBalance + totalPaymentPercent).toFixed(2)+"</b></td></tr>";
                tableResultsTbody.append(appendRow);
                
                tableResults.removeClass('hidden');
                
            }
            
            if (values.tbccType == 1){
                
                tableResultsTbody.html('');
                
                var previousBalance = values.tbccAmount;
                var paymentBalance = values.tbccAmount / values.tbccTerms;
                
                var totalPaymentBalance = 0;
                var totalPaymentPercent = 0;
                
                for(var i = 0; i <= values.tbccTerms; i++){
                    
                    if(i == 0){
                        
                        var appendRow = "<tr><td>"+i+"</td><td>"+previousBalance+"</td><td></td><td></td><td></td></tr>";
                        tableResultsTbody.append(appendRow);
                        
                    } else {

                        paymentPercent = previousBalance * ((values.tbccPercent / 100) / 12);
                        paymentTotal = paymentPercent + paymentBalance;
                        previousBalance = previousBalance - paymentBalance;
                        
                        totalPaymentBalance = totalPaymentBalance + paymentBalance;
                        totalPaymentPercent = totalPaymentPercent + paymentPercent;
                        
                        var appendRow = "<tr><td>"+i+"</td><td>"+previousBalance.toFixed(2)+"</td><td>"+paymentPercent.toFixed(2)+"</td><td>"+paymentBalance.toFixed(2)+"</td><td>"+paymentTotal.toFixed(2)+"</td></tr>";
                        tableResultsTbody.append(appendRow);
                        
                    }
                    
                }
                
                var appendRow = "<tr><td></td><td></td><td><b>"+totalPaymentPercent.toFixed(2)+"</b></td><td><b>"+totalPaymentBalance.toFixed(2)+"</b></td><td><b>"+(totalPaymentBalance + totalPaymentPercent).toFixed(2)+"</b></td></tr>";
                tableResultsTbody.append(appendRow);
                
                tableResults.removeClass('hidden');
                
            }
            
        });
        
    }
    
    
};