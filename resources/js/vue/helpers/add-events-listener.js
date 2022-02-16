export default function addEventsListener(target, events, callback) {
    for(let event of [].concat(events)) {
        target.addEventListener(event, callback)
    }
}
