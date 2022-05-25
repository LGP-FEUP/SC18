class FAQModel {
  final String uid, question, reply;

  FAQModel(this.uid, this.question, this.reply);

  FAQModel.fromJson(this.uid, Map<String, dynamic> json)
      : question = json['question'],
        reply = json['reply'];
}
