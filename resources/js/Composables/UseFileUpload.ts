import { ref } from "vue";
export function useFileUpload() {
    const imgSrc = ref(<string[]>[])
    const total = ref(0)
    function assignFiles(fileInput: HTMLInputElement, changeFiles: any[]) {
        fileInput.addEventListener('change', (ev: Event) => {
            const inputTarget = ev.target as HTMLInputElement
            if (inputTarget.files !== null) {
                for (let index = 0; index < inputTarget.files.length; index++) {
                    const file = inputTarget.files[index];
                    changeFiles.push(file);
                }
            }
            const newDt = new DataTransfer()
            changeFiles.forEach(file => newDt.items.add(file))
            fileInput.files = newDt.files
            total.value = fileInput.files.length

            handleFiles(newDt.files)
            deleteFile(newDt.files, fileInput)
        })
    }

    function dragenter(e: MouseEvent) {
        e.stopPropagation();
        e.preventDefault();
    }

    function dragover(e: MouseEvent) {
        e.stopPropagation();
        e.preventDefault();
    }
    function drop(e: any, changeFiles: any[], fileInput: HTMLInputElement) {
        e.stopPropagation();
        e.preventDefault();

        const dt = e.dataTransfer;

        for (let index = 0; index < dt.files.length; index++) {
            const file = dt.files[index];

            changeFiles.push(file);
        }
        const newDt = new DataTransfer()
        changeFiles.forEach(file => newDt.items.add(file))
        fileInput.files = newDt.files
        total.value = fileInput.files.length
        handleFiles(newDt.files);
        deleteFile(newDt.files, fileInput)
    }

    function deleteFile(files: FileList, fileInput: HTMLInputElement) {
        const buttons = document.querySelectorAll('.delete_file')
        const dt = new DataTransfer()
        buttons.forEach((btn: any) => {
            const btnIndex = parseInt(btn.value)
            btn.addEventListener('click', () => {
                for (let index = 0; index < files.length; index++) {
                    const file = files[index];
                    if (btnIndex !== index) {
                        dt.items.add(file)
                    }
                }
                files = dt.files
                fileInput.files = files
                total.value = fileInput.files.length
                btn.closest('.thumbnail_progress').remove()
            })
        })
    }
    function handleFiles(files: FileList) {
        // document.querySelectorAll('.thumbnail_progress').forEach(ele => ele.remove())
        for (let index = 0; index < files.length; index++) {
            const file = files[index];
            const src = ref('')



            if (!file.type.startsWith("image/")) {
                continue;
            }


            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = (e: any) => {
                src.value = e.target.result;
                imgSrc.value.push(src.value)
                console.log(imgSrc.value);

            };
        }
    }

    return {
        drop, dragenter, dragover, deleteFile, assignFiles, total, imgSrc
    }


}