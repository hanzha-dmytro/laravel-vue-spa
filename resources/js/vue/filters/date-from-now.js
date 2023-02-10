import moment from "moment/moment";

export default function dateFromNow(value, inputFormat = 'YYYY-MM-DD') {
    if (!value) return ''
    return moment(value, inputFormat).fromNow()
}
