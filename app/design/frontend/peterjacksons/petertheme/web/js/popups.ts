import $ = require("jquery");

export class Popups {

    constructor() {
        this._faqPopup();
        this._shippingPopup();
        this._contactPopup();
        this._successCloseOverlay();
        this._showSearch();
    }

    _showSearch() {
        $('.header-right__show-search-overlay').on('click', () => {
            $('.search-overlay').show();
        });
        $('.search-overlay').click(() => {
            $('.search-overlay').hide();
        });
        $('.search-overlay__form').click((event) => {
            event.stopPropagation();
        });
    }

    _faqPopup() {
        $('.faq-click, .faq__close, .faq__overlay').on('click', () => {
            $('.faq__overlay').toggle();
        });
        $('.faq__popup').click((e) => {
            e.stopPropagation();
        });
        $('.faq__title').on('click', function() {
            $(this).toggleClass('faq__title--open').next().slideToggle();
        });
    }

    _shippingPopup() {
        $(' .shipping-returns-click, .product-info-main__free-delivery-trigger ').on(' click ', () => {
            $(' .overlay__overlay-shipping ').toggle();
        });
        $(' .overlay__close, .overlay__overlay ').on(' click ', () => {
           $(' .overlay__overlay-shipping ').hide()
        });
        $(' .overlay__popup ').click((evt) => {
            evt.stopPropagation();
        });
    }

    _contactPopup() {
        $(' .contact-us-click-checkout ').on(' click ', () => {
            $(' .overlay__overlay-contact ').toggle();
        });
        $(' .overlay__close, .overlay__overlay ').on('click', () => {
            $(' .overlay__overlay-contact ').hide()
        });
        $(' .overlay__popup ').click((evt) => {
            evt.stopPropagation();
        });
    }

    _successCloseOverlay() {
        $('.popup-success__content').click((e) => {
            e.stopPropagation();
        });
        $('.popup-success, .popup-success__close, .popup-success__content .continue-button').on('click', () => {
            $('.popup-success').hide()
        });
    }
}
