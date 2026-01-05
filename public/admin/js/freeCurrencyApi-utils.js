let API_KEY = 'fca_live_MoXPprwiQiMtUJ9YHz4w1r5M1elZ34v7QIyML8L9';
const currencyRatesCache = { rates: {}, ts: 0 };

/**
 * Exchange an amount from one currency to another using "FreeCurrencyAPI.com"
 */
export async function exchangeCoinTo(amount, fromCurrency, toCurrency) {
    const newValue = Number(amount) || 0;
    if (!fromCurrency || !toCurrency || fromCurrency === toCurrency) return newValue;

    const now = Date.now();
    const cacheKey = fromCurrency + '_' + toCurrency;
    if (currencyRatesCache.rates[cacheKey] && (now - currencyRatesCache.ts) < 10 * 60 * 1000) {
        const rate = currencyRatesCache.rates[cacheKey];
        return newValue * rate;
    }

    try {
        const url = `https://api.freecurrencyapi.com/v1/latest?apikey=${API_KEY}&base_currency=${encodeURIComponent(fromCurrency)}&currencies=${encodeURIComponent(toCurrency)}`;
        const res = await fetch(url);
        const json = await res.json();
        const data = json.data ?? json.rates ?? json;
        const rate = (data && (data[toCurrency] || (data.rates && data.rates[toCurrency]))) ? Number(data[toCurrency] || data.rates[toCurrency]) : null;
        if (rate) {
            currencyRatesCache.rates[cacheKey] = rate;
            currencyRatesCache.ts = now;
            return newValue * rate;
        }
    } catch (e) {
        console.warn('freeCurrencyApi-utils: exchange fetch failed', e);
    }

    return newValue;
}

/**
 * Format an amount to a currency string with exchange conversion
 */
export async function formatCurrency(amount, fromCurrency = 'EUR') {
    const targetCurrency = (typeof window !== 'undefined' && window.currentCurrency) ? window.currentCurrency : 'EUR';
    const converted = await exchangeCoinTo(amount, fromCurrency, targetCurrency);
    return new Intl.NumberFormat(undefined, { style: 'currency', currency: targetCurrency }).format(converted);
}
