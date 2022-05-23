import 'package:flutter/material.dart';

import '../../services/user_service.dart';
import 'groups/components/group_carousel.dart';

class ForumsTab extends StatelessWidget {
  const ForumsTab({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: UserService.getInterestUIDs(),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            List<String> interests = response.data as List<String>;

            return ListView.builder(
                scrollDirection: Axis.vertical,
                itemCount: interests.length,
                itemBuilder: (BuildContext context, int index) {
                  return GroupCarousel(tagId: interests[index]);
                });
          }
        }
        return Container();
      },
    );
  }
}
