import moment from "moment/moment";

export default function dateFormat(value, outputFormat = 'DD-MM-YYYY', inputFormat = 'YYYY-MM-DD') {
    if (!value) return ''
    return moment(value, inputFormat).format(outputFormat)
}
