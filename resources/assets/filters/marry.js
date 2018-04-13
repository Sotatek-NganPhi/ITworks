const MESSAGES = {
    MARRY : '既婚',
    UNMARRY : '未婚',
}

export default (value) => {
    if (value === 1 || value === '1') {
        return MESSAGES.MARRY;
    }
    return MESSAGES.UNMARRY;
}
