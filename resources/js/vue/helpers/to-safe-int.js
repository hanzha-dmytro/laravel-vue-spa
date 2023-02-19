export default function toSafeInt (value) {
    const intValue = parseInt(value);
    return !isNaN(intValue) ? intValue : null;
}
