import 'package:erasmus_helper/models/tag.dart';
import 'package:erasmus_helper/models/user.dart';
import 'package:erasmus_helper/services/user_interests_service.dart';
import 'package:flutter/material.dart';

class ForumsTab extends StatelessWidget {
  const ForumsTab({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: Future.wait([
        UserInterestsService.getUsersWithTags([Tag("Music")])
      ]),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              final rep = response.data as List<dynamic>;
              print(rep[0] as List<UserModel>);
            }
          }
          return const Text("Forums");
    });
    // List<UserModel>? userList = await UserInterestsService.getUsersWithTags([Tag("Music")]);
  }
}