<div {{attributes}} data-loading="addClass(opacity-80) addAttribute(disabled)"  class="input-goup">
    <input type="text" placeholder="address" class="form-control" autocomplete="false" spellcheck="false"
        {{ live_action('setAddressLabel', {event:'input', debounce: 1000}) }} data-model="addressLabel">

    <ul class="list-group">
        {% for key, completion in autocompletions %}
        <li class="list-group-item">
            <button type="button" {{live_action('selectCompletion', {key: key})}} class="btn border-0 w-100 text-start">
                {{completion.fulltext}}
            </button>
        </li>
        {% endfor %}
    </ul>
</div>