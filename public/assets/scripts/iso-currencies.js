(function (angular) {
  'use strict';

  var module_name = 'isoCurrencies';
  var modules_dep = [];

  // Create module wp-ng iso currency module
  var wpNgIsoCurrency = angular.module(module_name, modules_dep);

  /**
   * Config Provider
   */
  wpNgIsoCurrency.provider('isoCurrencies', ['iso4217Currencies', function wpNgIsoCurrencyProvider( iso4217Currencies ) {

    this.code = 'USD';
    this.text = 'US Dollar';
    this.fraction = 2;
    this.symbol = '$';
    this.position = 'left';
    this.decimalSep = '.';
    this.thousandSep = ',';

    this.setCurrencyIso4217 = function(code) {
      if (code) {
        this.code = code.toUpperCase();
      }

      var iso_currency = iso4217Currencies[this.code];

      this.text = iso_currency.text;
      this.fraction = iso_currency.fraction;
      this.symbol = iso_currency.symbol;
    };

    this.setCurrencyIso4217();

    this.$get = [ function() {

      var currency = {
        code:         this.code,
        text:         this.text,
        fraction:     this.fraction,
        symbol:       this.symbol,
        position:     this.position,
        decimalSep:   this.decimalSep,
        thousandSep:  this.thousandSep
      };

      return {
        getCurrency: function () {
          return currency;
        },
        getCode: function() {
          return currency.code;
        },
        getText: function() {
          return currency.text;
        },
        getFraction: function() {
          return currency.fraction;
        },
        getSymbol: function() {
          return currency.symbol;
        },
        getPosition: function() {
          return currency.position;
        },
        getDecimalSep: function() {
          return currency.decimalSep;
        },
        getThousandSep: function() {
          return currency.thousandSep;
        }
      };
    }];


    this.setByCode = function(code) {
      this.setCurrencyIso4217(code);
    };

    this.setCode = function(code) {
      this.code = code.toUpperCase() || this.code;
    };

    this.setText = function(text) {
      if (angular.isDefined(text) && angular.isString(text)) {
        this.text = text;
      }
    };

    this.setFraction = function(fraction) {
      if (angular.isDefined(fraction) && angular.isNumber(fraction)) {
        this.fraction = fraction;
      }
    };

    this.setSymbol = function(symbol) {
      if (angular.isDefined(symbol)) {
        this.symbol = symbol;
      }
    };

    this.setPosition = function(position) {
      if (angular.isDefined(position) && angular.isString(position)) {
        this.position = position;
      }
    };

    this.setDecimalSep = function(decimalSep) {
      if (angular.isDefined(decimalSep) && angular.isString(decimalSep)) {
        this.decimalSep = decimalSep;
      }
    };

    this.setThousandSep = function(thousandSep) {
      if (angular.isDefined(thousandSep) && angular.isString(thousandSep)) {
        this.thousandSep = thousandSep;
      }
    };


  }]);


  /**
   * Filter
   */
  wpNgIsoCurrency.filter('isoCurrency', ['$filter', 'isoCurrencyService', function($filter, isoCurrencyService) {



    Number.prototype.numberFormat = function(decimals, dec_sep, thousand_sep) {
      dec_sep = typeof dec_sep !== 'undefined' ? dec_sep : '.';
      thousand_sep = typeof thousand_sep !== 'undefined' ? thousand_sep : ',';

      var parts = parseFloat( this.toFixed(decimals) ).toString().split('.');

      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousand_sep);

      return  parts.join(dec_sep);
    };


    /**
     * transforms an amount into the right format and currency according to a passed currency code (3 chars).
     *
     * @param float amount
     * @param string currencyCode e.g. EUR, USD
     * @param number fraction User specified fraction size that overwrites default value
     * @return string
     */
    return function(amount, currencyCode, fraction, dec_sep, thousand_sep, position) {

      var currency = isoCurrencyService.getCurrencyByCode(currencyCode);

      //Get the size fraction
      if (angular.isDefined(fraction)) {
        currency.fraction = fraction;
      }

      //Get the decimal separator
      if (angular.isDefined(dec_sep)) {
        currency.decimalSep = dec_sep;
      }

      //Get the thousand separator
      if (angular.isDefined(thousand_sep)) {
        currency.thousandSep = thousand_sep;
      }

      //Get the thousand separator
      if (angular.isDefined(position)) {
        currency.position = position;
      }


      //format number fraction size, decimal separator and thousand separator
      var amount_fraction = parseFloat(amount).numberFormat(currency.fraction, currency.decimalSep, currency.thousandSep);

      var result = '';

      switch (currency.position) {
        case 'left' :
          result = currency.symbol + amount_fraction;
          break;
        case 'right' :
          result = amount_fraction + currency.symbol;
          break;
        case 'left_space' :
          result = currency.symbol + '\u00A0' + amount_fraction;
          break;
        case 'right_space' :
          result = amount_fraction + '\u00A0' + currency.symbol;
          break;
      }

      return result;
    };

  }]);


  /**
   * iso4217 currency by code country
   */
  wpNgIsoCurrency.factory('isoCurrencyService', [ 'isoCurrencies', 'iso4217Currencies', function( isoCurrencies, iso4217Currencies ){

    var currency = isoCurrencies.getCurrency();

    function _set_currency_iso4217(code) {
      if (code) {
        currency.code = code.toUpperCase();
      }

      var iso_currency = iso4217Currencies[currency.code];

      currency.text = iso_currency.text;
      currency.fraction = iso_currency.fraction;
      currency.symbol = iso_currency.symbol;

      return currency;
    }

    return {

      /**
       * retrieves the object holding currency.
       *
       * @param string code
       * @return object
       */
      getCurrencyByCode: function(code) {

        if (code) {
          _set_currency_iso4217(code);
        }

        return currency;
      }
    };
  }]);


  /**
   * Constant
   */
  wpNgIsoCurrency.constant( 'iso4217Currencies', {
    'AFN': {
      text: 'Afghani',
      fraction: 2,
      symbol: '؋'
    },
    'EUR': {
      text: 'Euro',
      fraction: 2,
      symbol: '€'
    },
    'ALL': {
      text: 'Lek',
      fraction: 2,
      symbol: 'Lek'
    },
    'DZD': {
      text: 'Algerian Dinar',
      fraction: 2,
      symbol: false
    },
    'USD': {
      text: 'US Dollar',
      fraction: 2,
      symbol: '$'
    },
    'AOA': {
      text: 'Kwanza',
      fraction: 2,
      symbol: false
    },
    'XCD': {
      text: 'East Caribbean Dollar',
      fraction: 2,
      symbol: '$'
    },
    'ARS': {
      text: 'Argentine Peso',
      fraction: 2,
      symbol: '$'
    },
    'AMD': {
      text: 'Armenian Dram',
      fraction: 2,
      symbol: false
    },
    'AWG': {
      text: 'Aruban Florin',
      fraction: 2,
      symbol: 'ƒ'
    },
    'AUD': {
      text: 'Australian Dollar',
      fraction: 2,
      symbol: '$'
    },
    'AZN': {
      text: 'Azerbaijanian Manat',
      fraction: 2,
      symbol: 'ман'
    },
    'BSD': {
      text: 'Bahamian Dollar',
      fraction: 2,
      symbol: '$'
    },
    'BHD': {
      text: 'Bahraini Dinar',
      fraction: 3,
      symbol: false
    },
    'BDT': {
      text: 'Taka',
      fraction: 2,
      symbol: false
    },
    'BBD': {
      text: 'Barbados Dollar',
      fraction: 2,
      symbol: '$'
    },
    'BYR': {
      text: 'Belarussian Ruble',
      fraction: 0,
      symbol: 'p.'
    },
    'BZD': {
      text: 'Belize Dollar',
      fraction: 2,
      symbol: 'BZ$'
    },
    'XOF': {
      text: 'CF Franc BCEAO',
      fraction: 0,
      symbol: false
    },
    'BMD': {
      text: 'Bermudian Dollar',
      fraction: 2,
      symbol: '$'
    },
    'BTN': {
      text: 'Ngultrum',
      fraction: 2,
      symbol: false
    },
    'INR': {
      text: 'Indian Rupee',
      fraction: 2,
      symbol: ''
    },
    'BOB': {
      text: 'Boliviano',
      fraction: 2,
      symbol: '$b'
    },
    'BOV': {
      text: 'Mvdol',
      fraction: 2,
      symbol: false
    },
    'BAM': {
      text: 'Convertible Mark',
      fraction: 2,
      symbol: 'KM'
    },
    'BWP': {
      text: 'Pula',
      fraction: 2,
      symbol: 'P'
    },
    'NOK': {
      text: 'Norwegian Krone',
      fraction: 2,
      symbol: 'kr'
    },
    'BRL': {
      text: 'Brazilian Real',
      fraction: 2,
      symbol: 'R$'
    },
    'BND': {
      text: 'Brunei Dollar',
      fraction: 2,
      symbol: '$'
    },
    'BGN': {
      text: 'Bulgarian Lev',
      fraction: 2,
      symbol: 'лв'
    },
    'BIF': {
      text: 'Burundi Franc',
      fraction: 0,
      symbol: false
    },
    'KHR': {
      text: 'Riel',
      fraction: 2,
      symbol: '៛'
    },
    'XAF': {
      text: 'CF Franc BEAC',
      fraction: 0,
      symbol: false
    },
    'CAD': {
      text: 'Canadian Dollar',
      fraction: 2,
      symbol: '$'
    },
    'CVE': {
      text: 'Cabo Verde Escudo',
      fraction: 2,
      symbol: false
    },
    'KYD': {
      text: 'Cayman Islands Dollar',
      fraction: 2,
      symbol: '$'
    },
    'CLF': {
      text: 'Unidad de Fomento',
      fraction: 4,
      symbol: false
    },
    'CLP': {
      text: 'Chilean Peso',
      fraction: 0,
      symbol: '$'
    },
    'CNY': {
      text: 'Yuan Renminbi',
      fraction: 2,
      symbol: '¥'
    },
    'COP': {
      text: 'Colombian Peso',
      fraction: 2,
      symbol: '$'
    },
    'COU': {
      text: 'Unidad de Valor Real',
      fraction: 2,
      symbol: false
    },
    'KMF': {
      text: 'Comoro Franc',
      fraction: 0,
      symbol: false
    },
    'CDF': {
      text: 'Congolese Franc',
      fraction: 2,
      symbol: false
    },
    'NZD': {
      text: 'New Zealand Dollar',
      fraction: 2,
      symbol: '$'
    },
    'CRC': {
      text: 'Cost Rican Colon',
      fraction: 2,
      symbol: '₡'
    },
    'HRK': {
      text: 'Croatian Kuna',
      fraction: 2,
      symbol: 'kn'
    },
    'CUC': {
      text: 'Peso Convertible',
      fraction: 2,
      symbol: false
    },
    'CUP': {
      text: 'Cuban Peso',
      fraction: 2,
      symbol: '₱'
    },
    'ANG': {
      text: 'Netherlands Antillean Guilder',
      fraction: 2,
      symbol: 'ƒ'
    },
    'CZK': {
      text: 'Czech Koruna',
      fraction: 2,
      symbol: 'Kč'
    },
    'DKK': {
      text: 'Danish Krone',
      fraction: 2,
      symbol: 'kr'
    },
    'DJF': {
      text: 'Djibouti Franc',
      fraction: 0,
      symbol: false
    },
    'DOP': {
      text: 'Dominican Peso',
      fraction: 2,
      symbol: 'RD$'
    },
    'EGP': {
      text: 'Egyptian Pound',
      fraction: 2,
      symbol: '£'
    },
    'SVC': {
      text: 'El Salvador Colon',
      fraction: 2,
      symbol: '$'
    },
    'ERN': {
      text: 'Nakfa',
      fraction: 2,
      symbol: false
    },
    'ETB': {
      text: 'Ethiopian Birr',
      fraction: 2,
      symbol: false
    },
    'FKP': {
      text: 'Falkland Islands Pound',
      fraction: 2,
      symbol: '£'
    },
    'FJD': {
      text: 'Fiji Dollar',
      fraction: 2,
      symbol: '$'
    },
    'XPF': {
      text: 'CFP Franc',
      fraction: 0,
      symbol: false
    },
    'GMD': {
      text: 'Dalasi',
      fraction: 2,
      symbol: false
    },
    'GEL': {
      text: 'Lari',
      fraction: 2,
      symbol: false
    },
    'GHS': {
      text: 'Ghan Cedi',
      fraction: 2,
      symbol: false
    },
    'GIP': {
      text: 'Gibraltar Pound',
      fraction: 2,
      symbol: '£'
    },
    'GTQ': {
      text: 'Quetzal',
      fraction: 2,
      symbol: 'Q'
    },
    'GBP': {
      text: 'Pound Sterling',
      fraction: 2,
      symbol: '£'
    },
    'GNF': {
      text: 'Guine Franc',
      fraction: 0,
      symbol: false
    },
    'GYD': {
      text: 'Guyan Dollar',
      fraction: 2,
      symbol: '$'
    },
    'HTG': {
      text: 'Gourde',
      fraction: 2,
      symbol: false
    },
    'HNL': {
      text: 'Lempira',
      fraction: 2,
      symbol: 'L'
    },
    'HKD': {
      text: 'Hong Kong Dollar',
      fraction: 2,
      symbol: '$'
    },
    'HUF': {
      text: 'Forint',
      fraction: 2,
      symbol: 'Ft'
    },
    'ISK': {
      text: 'Iceland Krona',
      fraction: 0,
      symbol: 'kr'
    },
    'IDR': {
      text: 'Rupiah',
      fraction: 2,
      symbol: 'Rp'
    },
    'XDR': {
      text: 'SDR (Special Drawing Right)',
      fraction: 0,
      symbol: false
    },
    'IRR': {
      text: 'Iranian Rial',
      fraction: 2,
      symbol: '﷼'
    },
    'IQD': {
      text: 'Iraqi Dinar',
      fraction: 3,
      symbol: false
    },
    'ILS': {
      text: 'New Israeli Sheqel',
      fraction: 2,
      symbol: '₪'
    },
    'JMD': {
      text: 'Jamaican Dollar',
      fraction: 2,
      symbol: 'J$'
    },
    'JPY': {
      text: 'Yen',
      fraction: 0,
      symbol: '¥'
    },
    'JOD': {
      text: 'Jordanian Dinar',
      fraction: 3,
      symbol: false
    },
    'KZT': {
      text: 'Tenge',
      fraction: 2,
      symbol: 'лв'
    },
    'KES': {
      text: 'Kenyan Shilling',
      fraction: 2,
      symbol: false
    },
    'KPW': {
      text: 'North Korean Won',
      fraction: 2,
      symbol: '₩'
    },
    'KRW': {
      text: 'Won',
      fraction: 0,
      symbol: '₩'
    },
    'KWD': {
      text: 'Kuwaiti Dinar',
      fraction: 3,
      symbol: false
    },
    'KGS': {
      text: 'Som',
      fraction: 2,
      symbol: 'лв'
    },
    'LAK': {
      text: 'Kip',
      fraction: 2,
      symbol: '₭'
    },
    'LBP': {
      text: 'Lebanese Pound',
      fraction: 2,
      symbol: '£'
    },
    'LSL': {
      text: 'Loti',
      fraction: 2,
      symbol: false
    },
    'ZAR': {
      text: 'Rand',
      fraction: 2,
      symbol: 'R'
    },
    'LRD': {
      text: 'Liberian Dollar',
      fraction: 2,
      symbol: '$'
    },
    'LYD': {
      text: 'Libyan Dinar',
      fraction: 3,
      symbol: false
    },
    'CHF': {
      text: 'Swiss Franc',
      fraction: 2,
      symbol: 'CHF'
    },
    'LTL': {
      text: 'Lithuanian Litas',
      fraction: 2,
      symbol: 'Lt'
    },
    'MOP': {
      text: 'Pataca',
      fraction: 2,
      symbol: false
    },
    'MKD': {
      text: 'Denar',
      fraction: 2,
      symbol: 'ден'
    },
    'MGA': {
      text: 'Malagasy riary',
      fraction: 2,
      symbol: false
    },
    'MWK': {
      text: 'Kwacha',
      fraction: 2,
      symbol: false
    },
    'MYR': {
      text: 'Malaysian Ringgit',
      fraction: 2,
      symbol: 'RM'
    },
    'MVR': {
      text: 'Rufiyaa',
      fraction: 2,
      symbol: false
    },
    'MRO': {
      text: 'Ouguiya',
      fraction: 2,
      symbol: false
    },
    'MUR': {
      text: 'Mauritius Rupee',
      fraction: 2,
      symbol: '₨'
    },
    'XUA': {
      text: 'ADB Unit of ccount',
      fraction: 0,
      symbol: false
    },
    'MXN': {
      text: 'Mexican Peso',
      fraction: 2,
      symbol: '$'
    },
    'MXV': {
      text: 'Mexican Unidad de Inversion (UDI)',
      fraction: 2,
      symbol: false
    },
    'MDL': {
      text: 'Moldovan Leu',
      fraction: 2,
      symbol: false
    },
    'MNT': {
      text: 'Tugrik',
      fraction: 2,
      symbol: '₮'
    },
    'MAD': {
      text: 'Moroccan Dirham',
      fraction: 2,
      symbol: false
    },
    'MZN': {
      text: 'Mozambique Metical',
      fraction: 2,
      symbol: 'MT'
    },
    'MMK': {
      text: 'Kyat',
      fraction: 2,
      symbol: false
    },
    'NAD': {
      text: 'Namibi Dollar',
      fraction: 2,
      symbol: '$'
    },
    'NPR': {
      text: 'Nepalese Rupee',
      fraction: 2,
      symbol: '₨'
    },
    'NIO': {
      text: 'Cordob Oro',
      fraction: 2,
      symbol: 'C$'
    },
    'NGN': {
      text: 'Naira',
      fraction: 2,
      symbol: '₦'
    },
    'OMR': {
      text: 'Rial Omani',
      fraction: 3,
      symbol: '﷼'
    },
    'PKR': {
      text: 'Pakistan Rupee',
      fraction: 2,
      symbol: '₨'
    },
    'PAB': {
      text: 'Balboa',
      fraction: 2,
      symbol: 'B/.'
    },
    'PGK': {
      text: 'Kina',
      fraction: 2,
      symbol: false
    },
    'PYG': {
      text: 'Guarani',
      fraction: 0,
      symbol: 'Gs'
    },
    'PEN': {
      text: 'Nuevo Sol',
      fraction: 2,
      symbol: 'S/.'
    },
    'PHP': {
      text: 'Philippine Peso',
      fraction: 2,
      symbol: '₱'
    },
    'PLN': {
      text: 'Zloty',
      fraction: 2,
      symbol: 'zł'
    },
    'QAR': {
      text: 'Qatari Rial',
      fraction: 2,
      symbol: '﷼'
    },
    'RON': {
      text: 'New Romanian Leu',
      fraction: 2,
      symbol: 'lei'
    },
    'RUB': {
      text: 'Russian Ruble',
      fraction: 2,
      symbol: 'руб'
    },
    'RWF': {
      text: 'Rwand Franc',
      fraction: 0,
      symbol: false
    },
    'SHP': {
      text: 'Saint Helen Pound',
      fraction: 2,
      symbol: '£'
    },
    'WST': {
      text: 'Tala',
      fraction: 2,
      symbol: false
    },
    'STD': {
      text: 'Dobra',
      fraction: 2,
      symbol: false
    },
    'SAR': {
      text: 'Saudi Riyal',
      fraction: 2,
      symbol: '﷼'
    },
    'RSD': {
      text: 'Serbian Dinar',
      fraction: 2,
      symbol: 'Дин.'
    },
    'SCR': {
      text: 'Seychelles Rupee',
      fraction: 2,
      symbol: '₨'
    },
    'SLL': {
      text: 'Leone',
      fraction: 2,
      symbol: false
    },
    'SGD': {
      text: 'Singapore Dollar',
      fraction: 2,
      symbol: '$'
    },
    'XSU': {
      text: 'Sucre',
      fraction: 0,
      symbol: false
    },
    'SBD': {
      text: 'Solomon Islands Dollar',
      fraction: 2,
      symbol: '$'
    },
    'SOS': {
      text: 'Somali Shilling',
      fraction: 2,
      symbol: 'S'
    },
    'SSP': {
      text: 'South Sudanese Pound',
      fraction: 2,
      symbol: false
    },
    'LKR': {
      text: 'Sri Lank Rupee',
      fraction: 2,
      symbol: '₨'
    },
    'SDG': {
      text: 'Sudanese Pound',
      fraction: 2,
      symbol: false
    },
    'SRD': {
      text: 'Surinam Dollar',
      fraction: 2,
      symbol: '$'
    },
    'SZL': {
      text: 'Lilangeni',
      fraction: 2,
      symbol: false
    },
    'SEK': {
      text: 'Swedish Krona',
      fraction: 2,
      symbol: 'kr'
    },
    'CHE': {
      text: 'WIR Euro',
      fraction: 2,
      symbol: false
    },
    'CHW': {
      text: 'WIR Franc',
      fraction: 2,
      symbol: false
    },
    'SYP': {
      text: 'Syrian Pound',
      fraction: 2,
      symbol: '£'
    },
    'TWD': {
      text: 'New Taiwan Dollar',
      fraction: 2,
      symbol: 'NT$'
    },
    'TJS': {
      text: 'Somoni',
      fraction: 2,
      symbol: false
    },
    'TZS': {
      text: 'Tanzanian Shilling',
      fraction: 2,
      symbol: false
    },
    'THB': {
      text: 'Baht',
      fraction: 2,
      symbol: '฿'
    },
    'TOP': {
      text: 'Pa’anga',
      fraction: 2,
      symbol: false
    },
    'TTD': {
      text: 'Trinidad nd Tobago Dollar',
      fraction: 2,
      symbol: 'TT$'
    },
    'TND': {
      text: 'Tunisian Dinar',
      fraction: 3,
      symbol: false
    },
    'TRY': {
      text: 'Turkish Lira',
      fraction: 2,
      symbol: '₺'
    },
    'TMT': {
      text: 'Turkmenistan New Manat',
      fraction: 2,
      symbol: false
    },
    'UGX': {
      text: 'Ugand Shilling',
      fraction: 0,
      symbol: false
    },
    'UAH': {
      text: 'Hryvnia',
      fraction: 2,
      symbol: '₴'
    },
    'AED': {
      text: 'UAE Dirham',
      fraction: 2,
      symbol: false
    },
    'USN': {
      text: 'US Dollar (Next day)',
      fraction: 2,
      symbol: false
    },
    'UYI': {
      text: 'Uruguay Peso en Unidades Indexadas (URUIURUI)',
      fraction: 0,
      symbol: false
    },
    'UYU': {
      text: 'Peso Uruguayo',
      fraction: 2,
      symbol: '$U'
    },
    'UZS': {
      text: 'Uzbekistan Sum',
      fraction: 2,
      symbol: 'лв'
    },
    'VUV': {
      text: 'Vatu',
      fraction: 0,
      symbol: false
    },
    'VEF': {
      text: 'Bolivar',
      fraction: 2,
      symbol: 'Bs'
    },
    'VND': {
      text: 'Dong',
      fraction: 0,
      symbol: '₫'
    },
    'YER': {
      text: 'Yemeni Rial',
      fraction: 2,
      symbol: '﷼'
    },
    'ZMW': {
      text: 'Zambian Kwacha',
      fraction: 2,
      symbol: false
    },
    'ZWL': {
      text: 'Zimbabwe Dollar',
      fraction: 2,
      symbol: false
    }
  });


}(angular));
