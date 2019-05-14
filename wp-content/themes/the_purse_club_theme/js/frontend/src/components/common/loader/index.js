import React, { Component } from 'react';
import './index.css';
import './animate.css';
import svg from './ball-triangle.svg';


export default class Loader extends Component {

    constructor(props) {
        super(props);
        this.state = {
            loading: props.loading,
            enterAnimation: props.animation || 'fadeIn',
            exitAnimation: props.animation || 'fadeOut',
            animation: ''
        }
    }

    componentDidMount() {
        this.setState({
            animation: this.state.enterAnimation
        });
    }

    componentDidUpdate(prevProps) {
        if (prevProps.loading && !this.props.loading) {
            this.setState({
                animation: this.state.exitAnimation
            });
            setTimeout(() => {
                this.setState({
                    loading: false
                })
            }, 1000);
        } else if (!prevProps.loading && this.props.loading) {
            this.setState({
                loading: true,
                animation: this.state.enterAnimation
            });
        }
    }

    render () {
        return this.state.loading && (
            <div className={`loader-wrapper animated ${this.state.animation}`}>
                <div className="loader" id={'loader-'.concat(this.props.id)}>
                    <img src={svg} alt='loader' />
                </div>
            </div>
        );
    }

}

Loader.defaultProps = {
    loading: false
}
