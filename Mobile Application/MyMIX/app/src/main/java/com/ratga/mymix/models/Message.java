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


    public Message(Integer userId, Integer sessionId, String value) {
        this.userId = userId;
        this.sessionId = sessionId;
        this.value = value;
    }

    public Message(Integer userId, Integer sessionId, String value, Session session, User user) {
        this(
                0, //UserId
                0, //SessionId
                "Test" //Value
        );
        this.session = session;
        this.user = user;

    }

    public Message() {
        this(
                0, //UserId
                0, //SessionId
                "Test" //Value
        );
        this.messageId = 0;
        this.creationTime = new Date(0);

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
        return this.user;
    }

    @Override
    public Date getCreatedAt() {
        return creationTime;
    }
}
