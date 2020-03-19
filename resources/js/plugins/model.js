let VueModel = class VueModel {
    constructor(header=null, body=null, type=null, visible=true) {
        this.header = header || 'Model Header';
        this.body = body || 'Model Body';
        this.type = type || 'Model Type';
        this.visible = visible || 'Model Visible';
    }

    title(header) {
        this.header = header;
        return this;
    }

    body(body) {
        this.body = body;
        return this;
    }

    appearance(type) {
        this.type = type;
        return this;
    }

    success() {
        this.type = 'success';
        return this;
    }

    error() {
        this.type = 'error';
        return this;
    }
    info() {
        this.type = 'info';
        return this;
    }
    
    warning() {
        this.type = 'warning';
        return this;
    }

    show() {
        window.bus.$emit('show-modal', this);
        return this;
    }

    dismiss() {
        window.bus.$emit('dismiss-modal');
        return this;
    }
}

export default VueModel;