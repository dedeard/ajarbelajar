<div x-data="markdown" class="border bg-white">
    <div class="flex markdown-tab">
        <button type="button" class="!bg-gray-300">Write</button>
        <button type="button">Preview</button>
    </div>
    <div class="flex markdown-actions border-t bg-gray-300">
        <button type="button" @click="formatText('bold')">
            <i class="ft ft-bold"></i>
        </button>
        <button type="button" @click="formatText('italic')">
            <i class="ft ft-italic"></i>
        </button>
        <button type="button" @click="formatText('img')">
            <i class="ft ft-image" @click="formatText('img')"></i>
        </button>
        <button type="button">
            <i class="ft ft-terminal" @click="formatText('quote')"></i>
        </button>
        <button type="button">
            <i class="ft ft-code" @click="formatText('code')"></i>
        </button>
        <button type="button">
            <i class="ft ft-hash" @click="formatText('codeBlock')"></i>
        </button>
        <button type="button">
            <i class="ft ft-list" @click="formatText('listU')"></i>
        </button>
        <button type="button" @click="formatText('link')">
            <i class="ft ft-link"></i>
        </button>
    </div>
    <div class="p-2 bg-gray-300">
        <textarea x-ref="textarea" name="{{ $name }}" id="{{ $name }}"
            class="block w-full h-44 !border-0 !ring-0"></textarea>
    </div>
</div>
