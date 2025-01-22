import Component from "ShopUi/models/component";
import $ from 'jquery';

export default class LineOfCredit extends Component {
    protected readyCallback(): void {
    }

    protected init(): void {
        super.init();
    }

}
$(document).ready(() => {
    const lineOfCreditPaymentSelector = $('#paymentForm_paymentSelection_dummyPaymentLineOfCredit');
    if (lineOfCreditPaymentSelector != null) {
        executeActionBasedOnLimit(lineOfCreditPaymentSelector);
    }
})

/**
 * @param selector
 */
function executeActionBasedOnLimit(selector: object) {
    $.get('/loc-transactions/check', function (response: object) {
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        const limit = (response.line_of_credit_limit);
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        const canProceed = (response.canProceed);
        if (canProceed) {
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-ignore
            selector.children('label').append(`<span class='line-of-credit-limit-value'>Availaible Limit: ${limit}</span>`);
        } else {
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-ignore
            selector.hide()
        }

    })
}
