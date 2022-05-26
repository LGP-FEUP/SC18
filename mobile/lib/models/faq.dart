import 'package:erasmus_helper/models/model.dart';

class FAQModel extends model{
  final String uid, question, reply;

  FAQModel(this.uid, this.question, this.reply);

  FAQModel.fromJson(this.uid, Map<String, dynamic> json)
      : question = json['question'],
        reply = json['reply'];

  @override
  Map<String, dynamic> toJson() {
    // TODO: implement toJson
    throw UnimplementedError();
  }
}
