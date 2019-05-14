import React, { Component } from 'react';
import { Redirect, Link } from 'react-router-dom';
import './index.css';
import './media.css';

import TPCStorage from './../common/storage';


export default class Counter extends Component {

    static COUNTER_TIME = (60 * 60);  // 1 Hour

    constructor(props) {
        super(props);
        this.storage = new TPCStorage();
        let timeStart = this.storage.getItem(props.TIMER_KEY, '');
        let offset = 0;

        let countDown = Boolean(timeStart);
        if (window.wpReactSettings.created) {
            let created = parseInt(window.wpReactSettings.created) * 1000;
            countDown = !(created + (this.constructor.COUNTER_TIME * 1000) < new Date().getTime());
        } else {
            if (countDown) {
                countDown = !(timeStart + (Counter.COUNTER_TIME * 1000) < new Date().getTime());
            } else {
                countDown = false;
            }
        }

        if (!timeStart) {
            timeStart = new Date().getTime();
            this.storage.setItem(props.TIMER_KEY, timeStart);
            offset = (timeStart + (this.constructor.COUNTER_TIME)) - timeStart;
        } else {
            timeStart = parseInt(timeStart);
            let timeEnd = timeStart + ((this.constructor.COUNTER_TIME) * 1000);
            offset = (timeEnd - new Date().getTime()) / 1000;
        }
        this.state = {
            time: '',
            seconds: offset,
            show: window.wpReactSettings.userEmail && countDown
        }
    }

    componentDidMount() {
        this.setState()
        this.startTimer();
    }

    startTimer() {
        this.timer = setInterval(this.countDown.bind(this), 1000);
    }

    countDown() {
        let seconds = this.state.seconds - 1;
        this.setState({
            time: this.secondsToTime(seconds),
            seconds
        });

        if (seconds <= 1) {
            clearInterval(this.timer);
            this.props.onDown && this.props.onDown();
            this.setState({
                seconds: 'EXPIRED',
                show: false
            });
        }
    }

    secondsToTime(secs) {
        let hours = Math.floor(secs / (60 * 60));
        let minutes = Math.floor((secs % (60 * 60)) / 60);
        let seconds = Math.ceil((secs % (60 * 60)) % 60);
        return `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
    }

    render() {
        return this.state.show && (
            <div>
                <div class="shop-counter-container">
                    <div class="shop-counter-inner">
                        <div class="timer_wrap upper">
                            <span class="timer-row-left upper">offer ends in:</span>
                            <span id="compact" class="timer hasCountdown" data-autotag="postreg-countdown"><span class="countdown_row countdown_amount"> {this.state.time} </span></span>
                            <span class="timer-row-right upper">time is running out!</span>
                        </div>
                    </div>
                </div>
            </div>
        )
    }

}