package com.ratga.mymix.models;

import com.stfalcon.chatkit.commons.models.IMessage;

import java.util.Date;

public class Message implements IMessage {
    private Integer messageId;
    private Integer userId;
    private Integer sessionId;
    private String value;
    private Date creationTime;
    private Session session;
    private User user;

    public Integer getMessageId() {
        return this.messageId;
    }

    public void setMessageId(Integer messageId) {
        this.messageId = messageId;
    }

    public Integer getUserId() {
        return this.userId;
    }

    public void setUserId(Integer userId) {
        this.userId = userId;
    }

    public Integer getSessionId() {
        return this.sessionId;
    }

    public void setSessionId(Integer sessionId) {
        this.sessionId = sessionId;
    }

    public String getValue() {
        return this.value;
    }

    public void setValue(String value) {
        this.value = value;
    }

    public Date getCreationTime() {
        return this.creationTime;
    }

    public void setCreationTime(Date creationTime) {
        this.creationTime = creationTime;
    }

    public Session getSession() {
        return this.session;
    }

    public void setSession(Session session) {
        this.session = session;
    }


    public void setUser(User user) {
        this.user = user;
    }


    public Message(User user, Session session, String value) {
        this.userId = user.getUserId();
        this.sessionId = session.getSessionId();
        this.user = user;
        this.session = session;
        this.value = value;
        this.creationTime = new Date();
    }

    public Message() {

    }

    @Override
    public String getId() {
        return String.valueOf(messageId);
    }

    @Override
    public String getText() {
        return value;
    }

    public User getUser() {
        return (user == null) ? new User() : user;
    }

    @Override
    public Date getCreatedAt() {
        return creationTime;
    }
}
