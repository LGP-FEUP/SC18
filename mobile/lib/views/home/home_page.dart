import 'package:erasmus_helper/models/tag.dart';
import 'package:erasmus_helper/services/user_interests_service.dart';
import 'package:erasmus_helper/services/user_service.dart';
import 'package:erasmus_helper/views/app_topbar.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

// TODO : replace this page with the good content
class HomePage extends StatelessWidget {
  const HomePage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    /*
    return AppTopBar(
      body: Column(
        children: const [Text("Home Page")],
      ),
      title: "Home",
    );*/
    return FutureBuilder(
        future: Future.wait([UserInterestsService.getUsersWithTags([Tag("Music")])]),
        builder: (context, response) {
          if (response.connectionState == ConnectionState.done) {
            if (response.data != null) {
              print(response.data);
            }
          }
          return const Text("Home Page");
        }
    );
  }
}