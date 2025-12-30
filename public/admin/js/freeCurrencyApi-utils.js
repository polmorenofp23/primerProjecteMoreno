let API_KEY = 'fca_live_MoXPprwiQiMtUJ9YHz4w1r5M1elZ34v7QIyML8L9';
const _fx_cache = { rates: {}, ts: 0 };

/**
 * Exchange an amount from one currency to another using "FreeCurrencyAPI.com"

 */
export async function exchangeCoinTo(amount, fromCurrency, toCurrency) {
    const amt = Number(amount) || 0;
    if (!fromCurrency || !toCurrency || fromCurrency === toCurrency) return amt;

    const now = Date.now();
    const cacheKey = fromCurrency + '_' + toCurrency;
    if (_fx_cache.rates[cacheKey] && (now - _fx_cache.ts) < 10 * 60 * 1000) {
        const rate = _fx_cache.rates[cacheKey];
        return amt * rate;
    }

    if (!API_KEY) {
        console.warn('freeCurrencyApi-utils: API key not set — returning original amount');
        return amt;
    }

    try {
        const url = `https://api.freecurrencyapi.com/v1/latest?apikey=${API_KEY}&base_currency=${encodeURIComponent(fromCurrency)}&currencies=${encodeURIComponent(toCurrency)}`;
        const res = await fetch(url);
        const json = await res.json();
        const data = json.data ?? json.rates ?? json;
        const rate = (data && (data[toCurrency] || (data.rates && data.rates[toCurrency]))) ? Number(data[toCurrency] || data.rates[toCurrency]) : null;
        if (rate) {
            _fx_cache.rates[cacheKey] = rate;
            _fx_cache.ts = now;
            return amt * rate;
        }
    } catch (e) {
        console.warn('freeCurrencyApi-utils: exchange fetch failed', e);
    }

    return amt;
}
