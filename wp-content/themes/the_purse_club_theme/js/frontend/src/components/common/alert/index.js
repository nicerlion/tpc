import React, { Component } from 'react';
import './index.css';


export default class Alert extends Component {

    constructor (props) {
        super(props);

        this.delay = this.props.delay || 10000;
        this.state = {
            visible: true 
        }
        this.setTimer = this.setTimer.bind(this);
    }

    componentDidMount() {
        this.setTimer();
    }

    setTimer() {
        this._timer = setTimeout(() => {
            this.setState({visible: false});
            this.props.onHide && this.props.onHide();
        }, this.delay);
    }

    componentWillUnmount() {
        clearTimeout(this._timer);
    }

    render() {
        return this.state.visible && (
            <div>
                <ul class={`bas-alert bas-alert-${this.props.type}`}>
                    <li>{ this.props.message }</li>
                </ul>
            </div>
        );
    }
}
