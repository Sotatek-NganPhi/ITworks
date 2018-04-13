const MESSAGES = {
    MALE : '男性',
    FEMALE : '女性',
}

export default (value) => {
    if (value === 1 || value === '1') {
        return MESSAGES.MALE;
    }
    return MESSAGES.FEMALE;
}
