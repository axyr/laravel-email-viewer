<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Email Viewer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3.4.31/dist/vue.global.js"></script>
</head>
<body class="bg-gray-100">
<div id="app">
</div>
<script>
    const {createApp, ref} = Vue;

    createApp({
        setup() {
            const currentEmail = ref(null);
            const emails = ref([]);

            const formatDate = function (date) {
                const emailDate = new Date(date);
                const options = {
                    weekday: 'short',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                return new Intl.DateTimeFormat('en-US', options).format(emailDate);
            };

            const showEmail = function (email) {
                currentEmail.value = email;
            };

            const nl2br = function (str) {
                return str.replace(/\n/g, '<br>');
            };

            const escapeHtml = function (str) {
                var div = document.createElement('div');
                div.appendChild(document.createTextNode(str));
                return div.innerHTML;
            };

            const processEmailContent = function (rawContent) {
                return nl2br(escapeHtml(rawContent));
            };

            fetch('/emails/json')
                .then(x => x.json())
                .then(data => emails.value = data.data);

            return {
                currentEmail,
                emails,
                formatDate,
                showEmail,
                processEmailContent
            };
        },
        template:
            `
                <div class="h-screen p-6">
                    <div class="flex gap-6 h-full">
                        <div class="flex-none bg-white border-b rounded shadow-sm overflow-y-scroll md:w-96">
                            <div v-for="email in emails">
                                <div @click="showEmail(email)" class="border-b cursor-pointer p-3 text-sm hover:bg-gray-50" :class="{ 'bg-gray-100': currentEmail?.id === email.id }">
                                    <h3 class="font-medium pb-1">
                                        {{ email.subject.substring(0, 35) }}
                                    </h3>
                                    <div class="grid grid-cols-6 w-full text-xs">
                                        <span class="col-span-4">To: {{ email.to.substring(0, 25) }}</span>
                                        <span class="col-span-2 text-right">{{ formatDate(email.date) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 bg-white rounded shadow-sm h-full overflow-y-hidden">

                            <div v-if="currentEmail" class="p-3 border-b overflow-y-hidden">
                                <h2 class="text-2xl">{{ currentEmail.subject }}</h2>
                                <div class="pt-3 text-sm">
                                    <table>
                                        <tbody class="[&>tr>th]:text-left [&>tr>th]:font-medium [&>tr>td]:text-gray-500 [&>tr>*]:py-1">
                                        <tr>
                                            <th>From:</th>
                                            <td><h2>{{ currentEmail.from }}</h2></td>
                                        </tr>
                                        <tr>
                                            <th>To:</th>
                                            <td><h2>{{ currentEmail.to }}</h2></td>
                                        </tr>
                                        <tr>
                                            <th>Date:</th>
                                            <td><h2>{{ currentEmail.date }}</h2></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-if="currentEmail" class="h-full overflow-y-hidden">
                                <section class="flex flex-row flex-wrap h-full">
                                    <input id="tab-1" type="radio" name="tabs" class="peer/tab-1 opacity-0 absolute" checked />
                                    <label for="tab-1" class="cursor-pointer peer-checked/tab-1:border-b-2 ml-3 p-3 block">HTML</label>
                                    <input id="tab-2" type="radio" name="tabs" class="peer/tab-2 opacity-0 absolute" />
                                    <label for="tab-2" class="cursor-pointer peer-checked/tab-2:border-b-2 ml-3 p-3 block">Headers</label>
                                    <input id="tab-3" type="radio" name="tabs" class="peer/tab-3 opacity-0 absolute" />
                                    <label for="tab-3" class="cursor-pointer peer-checked/tab-3:border-b-2 ml-3 p-3 block">Raw</label>

                                    <div class="basis-full h-0 border-b"></div>

                                    <div class="hidden peer-checked/tab-1:block pt-6 p-3 w-full h-full overflow-y-scroll flex flex-col">
                                        <iframe class="w-full h-full border-0 flex-grow" :srcdoc="currentEmail.html"></iframe>
                                    </div>

                                    <div class="hidden peer-checked/tab-2:block pt-6 p-3 w-full h-full overflow-y-scroll">
                                        <div class="border rounded-md bg-white w-full">
                                            <table class="w-full">
                                                <tbody class="[&>tr>th]:text-left [&>tr>th]:font-medium [&>tr>td]:text-gray-500 [&>tr>*]:p-2">
                                                <tr v-for="(value, name, index) in currentEmail.headers" :class="{ 'border-b': index !== Object.keys(currentEmail.headers).length - 1 }">
                                                    <th class="capitalize">{{ name.replace('x-', '') }}:</th>
                                                    <td>{{ value }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="hidden peer-checked/tab-3:block pt-6 p-3 w-full h-full overflow-y-scroll" v-html="processEmailContent(currentEmail.raw)" />
                                </section>
                            </div>
                        </div>
                    </div>
                </div>`
    }).mount('#app');
</script>
</body>
</html>
